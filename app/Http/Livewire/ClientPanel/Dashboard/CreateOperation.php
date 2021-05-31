<?php

namespace App\Http\Livewire\ClientPanel\Dashboard;

use App\Http\Livewire\ClientPanel\Dashboard\CreateOperationButton;
use App\Models\BankCode;
use App\Models\ClientBankProduct;
use App\Models\Operation;
use App\Models\OperationType;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateOperation extends Component
{
    // Zmienna typu bool odpowiadająca za widoczność modal-card.
    public $modalVisible;
    // Zmienna przechowująca wybrany typ operacji
    public $operation_type;
    // Zmienna przechowująca nazwę banku po aktualizacji pola z numerem rachunku
    public $bankName;

    // Pola formularza
    public $transaction_recipient_name, $transaction_recipient_address, $transaction_recipient_iban,
            $operation_from_bank_account_id, $operation_to_bank_account_id, $transaction_title, $operation_scheduled_at, $transaction_amount;

    /**
     * Funkcja aktywowana przyciskiem "Wykonaj przelew".
     */
    public function showCreateOperationModal()
    {
        $this->modalVisible = true;
    }

    /**
     * "Zerowanie" zmiennych przy montowaniu komponentu.
     */
    public function mount()
    {
        $this->modalVisible = false;
        $this->operation_type = null;
        $this->bankName = null;
    }

    /**
     * Funkcja renderująca widok ze zmiennymi.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $clientBankProducts = ClientBankProduct::where('user_id', Auth::user()->id)->get(); // Wyświetlanie rachunków posiadanych przez zalogowanego użytkownika
        $operationTypes = OperationType::all(); // Pobieranie wszystkich typów operacji na potrzeby pola select (wybór typu przelewu)
        $selected_operation_type = $this->operation_type; // Przekazanie wybranego typu operacji

        return view('livewire.client-panel.dashboard.create-operation', compact('clientBankProducts', 'operationTypes', 'selected_operation_type'));
    }

    /**
     *  Sprawdzenie kodu banku i przypisanie jego nazwy z bazy danych do zmiennej $bankName.
     *  Funkcja jest aktywowana za każdą zmianą w polu transaction_recipient_iban
     */
    public function CheckBankByIban()
    {
        $iban = trim(str_replace(' ', '', $this->transaction_recipient_iban)); // Pobranie numeru rachunku z formularza i usunięcie z niego ewentualnych spacji
        $bankNumber = mb_substr($iban, 4, 4); // Obcięcie kodu kraju i sumy kontrolnej i pobranie tylko 4 cyfr kodu banku
        $bankCode = BankCode::where('bank_number', $bankNumber)->first(); // Sprawdzenie czy istnieje taki kod banku w bazie danych
        if (!$bankCode) { // jeśli nie istnieje, wyświetl informację
            $this->bankName = "Nie mamy tego banku w bazie.";
        } else {
            $this->bankName = $bankCode->bank_name; // zapisanie do zmiennej dynamicznej
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitOperation()
    {
        // Przelew krajowy
        if($this->operation_type == 1)
        {
            $this->transaction_recipient_iban = trim(str_replace(' ', '', $this->transaction_recipient_iban)); // usunięcie wszystkich spacji

            $this->validate([
                'transaction_recipient_name'        => 'required',
                'transaction_recipient_address'     => 'required',
                'transaction_recipient_iban'        => 'required|min:28',
                'operation_from_bank_account_id'    => 'required',
                'transaction_title'                 => 'required',
                'operation_scheduled_at'            => 'required|date',
                'transaction_amount'                => 'required|numeric'
            ]);

            $fromClientBankAccount = ClientBankProduct::where('id', $this->operation_from_bank_account_id)->first();

            // Tworzenie przelewu
            $transaction = Transaction::create([
                'title'                 => $this->transaction_title,
                'recipient_name'        => $this->transaction_recipient_name,
                'recipient_address'     => $this->transaction_recipient_address,
                'recipient_iban'        => $this->transaction_recipient_iban,
                'sender_name'           => Auth::user()->FullName,
                'sender_address'        => Auth::user()->FullAddress,
                'sender_iban'           => $fromClientBankAccount->iban,
                'amount'                => $this->transaction_amount,
                'currency'              => 'PLN',
            ]);

            // Tworzenie operacji i wiązanie jej z utworzonym wcześniej przelewem
            $operation = Operation::create([
                'operation_type_id'     => $this->operation_type,
                'from_bank_account_id'  => $this->operation_from_bank_account_id,
                'to_bank_account_id'    => null,
                'transaction_id'        => $transaction->id,
                'scheduled_at'          => $this->operation_scheduled_at,
                'status_id'             => 5
            ]);

            // Odjęcie salda z konta
            $fromClientBankAccount->balance -= $transaction->amount;
            $fromClientBankAccount->save();

            if (Carbon::parse($operation->sheduled_at)->isToday() and $this->CheckIfInsideBankTransaction($this->transaction_recipient_iban))
            {
                // Konto klienta z numerem IBAN, do którego wysyłany jest przelew
                $transactionRecipientAccount = ClientBankProduct::where('iban', $this->transaction_recipient_iban)->first();
                $transactionRecipientAccount->balance += $transaction->amount; // Zwiększenie salda o kwotę przelewu
                $transactionRecipientAccount->save();

                $operation->to_bank_account_id = $transactionRecipientAccount->id; // przypisanie id rachunku innego klienta banku
                $operation->status_id = 1; // zmiana statusu na Zrealizowany
                $operation->save();
            }

            session()->flash('message', 'Pomyślnie utworzono nową operację. Otrzymała ona numer # ' . $operation->id . ".");
            return redirect()->to(route('dashboard'));
        }

        // Przelew własny
        if($this->operation_type == 2)
        {
            $this->validate([
                'operation_from_bank_account_id'    => 'required',
                'operation_to_bank_account_id'      => 'required',
                'transaction_title'                 => 'required',
                'operation_scheduled_at'            => 'required|date',
                'transaction_amount'                => 'required|numeric'
            ]);

            $fromClientBankAccount = ClientBankProduct::where('id', $this->operation_from_bank_account_id)->first();
            $toClientBankAccount = ClientBankProduct::where('id', $this->operation_to_bank_account_id)->first();

            // Tworzenie przelewu
            $transaction = Transaction::create([
                'title'                 => $this->transaction_title,
                'sender_name'           => Auth::user()->FullName,
                'sender_address'        => Auth::user()->FullAddress,
                'sender_iban'           => $fromClientBankAccount->iban,
                'amount'                => $this->transaction_amount,
                'currency'              => 'PLN',
            ]);

            // Tworzenie operacji i wiązanie jej z utworzonym wcześniej przelewem
            $operation = Operation::create([
                'operation_type_id'     => $this->operation_type,
                'from_bank_account_id'  => $this->operation_from_bank_account_id,
                'to_bank_account_id'    => $this->operation_to_bank_account_id,
                'transaction_id'        => $transaction->id,
                'scheduled_at'          => $this->operation_scheduled_at,
                'status_id'             => 5 // status = oczekująca
            ]);

            // Odjęcie salda z konta
            $fromClientBankAccount->balance -= $transaction->amount;
            $fromClientBankAccount->save();

            // Dodanie salda do konta własnego
            if (Carbon::parse($operation->sheduled_at)->isToday())
            {
                $toClientBankAccount->balance += $transaction->amount;
                $toClientBankAccount->save();

                $operation->status_id = 1;
                $operation->save();
            }

            session()->flash('message', 'Pomyślnie utworzono nową operację. Otrzymała ona numer # ' . $operation->id . ".");
            return redirect()->to(route('dashboard'));
        }

        else {
            return redirect()->to(route('dashboard'));
        }
    }

    /**
     * Sprawdzenie, czy przelew idzie na konto w tym samym banku.
     * Kod laraBanku to 4030.
     *
     * @param string $iban
     * @return bool
     */
    public function CheckIfInsideBankTransaction(string $iban): bool
    {
        $bankNumber = mb_substr($iban, 4, 4); // Obcięcie kodu kraju i sumy kontrolnej i pobranie tylko 4 cyfr kodu banku
        $bankCode = BankCode::where('bank_number', $bankNumber)->first();
        if ($bankCode->bank_number == 4030) { // jeśli kod banku to 4030 (LaraBank)
            return true;
        } else {
            return false;
        }
    }
}
