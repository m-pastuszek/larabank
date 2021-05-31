<?php

namespace App\Http\Livewire\ClientPanel;

use App\Models\BankCode;
use App\Models\ClientBankProduct;
use Faker\Factory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowBankProduct extends Component
{
    public $addClientBankProductConfirmation = false;
    public $bankProduct;

    public function addingClientBankProductModal()
    {
        $this->resetErrorBag();
        $this->addClientBankProductConfirmation = true;
    }

    public function addClientBankAccount($bank_product_id)
    {
        ClientBankProduct::create([
                'iban'              => $this->generateIbanNumber(),
                'balance'           => 0.00,
                'bank_product_id'   => $bank_product_id,
                'user_id'           => Auth::user()->id,
                'panel_color'       => 'blue'
        ]);

        session()->flash('message', 'Pomyślnie dodano produkt bankowy.');
        return redirect()->to(route('bank-products.index'));
    }

    /**
     * Funkcja generująca numer IBAN
     *
     * @return string
     */
    private function generateIbanNumber() {
        $countryCode = 'PL';  // kod kraju
        $checkSum = rand(10, 99); // losowa dwucyfrowa suma kontrolna

        $bankCode = BankCode::where('id', 13)->first(); // laraBank
        $bankNumber = $bankCode->bank_number . '0000';  // pobranie z bazy numeru odpowiadającego laraBankowi i dodanie 4 zer
        $accountNumber = $this->generateAcconuntNumber(); // generowanie 16-cyfrowego numeru rachunku

        $iban = $countryCode . $checkSum . $bankNumber . $accountNumber; // scalenie wszytkiego w numer IBAN
        return $iban;
    }

    /**
     * Funkcja generująca losowy 16-cyfrowy numer rachunku
     *
     * @return string
     */
    private function generateAcconuntNumber(){
        $accountNumber = '';
        for($i = 0; $i < 16; $i++) {
            $accountNumber .= mt_rand(0, 9);
        }
        return $accountNumber;
    }

    public function render()
    {
        return view('livewire.client-panel.show-bank-product');
    }
}
