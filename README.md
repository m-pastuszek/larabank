<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Projekt aplikacji bankowej - LaraBank

## Środowisko
**Wersja PHP** : 7.3

Projekt aplikacji bankowej został wykonany w oparciu o framework Laravel w wersji 8.21. Do budowy layoutu wykorzystano framework Tailwind CSS, a sam panel klienta w oparciu o Jetstream i Livewire.

Do budowy panelu administracyjnego wykorzystano otwarto-źródłowego Voyagera.

## Mapa strony
**Użytkownik niezalogowany**:
- / — Strona główna
- /login — Logowanie
- /register — Rejestracja
**Użytkownik zalogowany**:
- /dashboard — Panel klienta
- /produkty-bankowe — Strona z produktami bankowymi dostępnymi dla Klienta
- /user/profile — Zarządzanie swoim profilem

**Zarządzanie (Panel administratorski)**:
- /admin — Admin Panel
- /users — Użytkownicy
- /transactions — Przelewy
- /operations — Operacje
- /client-bank-products — Produkty bankowe klientów
- /bank-products — Produkty bankowe
- /bank-products-types — Typy produktów bankowych
- /bank-codes — Kody banków
- /operation-types — Typy operacji
- /voivodeships — Województwa
- oraz pozostałe widoczne w menu pod Administracja

## Diagram bazy danych

<a href="https://ibb.co/pfdQK8M"><img src="https://i.ibb.co/m940yw2/Diagram-bazy-danych-larabank.png" alt="Diagram-bazy-danych-larabank" border="0"></a>

### Istotne tabele

- bank_codes — tabela zawierająca kody banków na potrzeby wyświetlania nazwy banku, do którego klient wysyła przelew.
- bank_products — tabela zawierająca produkty bankowe dostępne w ofercie banku.
- bank_products_types — tabela zawierająca typy ww. produktów bankowych.
- client_bank_products — tabela zawierająca produkty bankowe klientów. Jeden klient może posiadać wiele produktów bankowych.
- operation_statuses — tabela zawierająca statusy operacji.
- operation_types — tabela zawierająca typy operacji.
- operations — tabela zawierające operacje wykonywane na rachunkach przez klientów.
- roles — tabela zawierająca role, jakie mogą zostać przypisane użytkownikom.
- transactions — tabela zawierające dane o wykonywanych przelewach.
- users  — tabela zawierająca dane o użytkownikach.
- voivodeships — tabela zawierająca województwa dostępne do wyboru.

## Krótki opis ważniejszych relacji

**Produkty bankowe**
Produkty bankowe dodawane są w panelu administracyjnym. Klient ma możliwość aktywacji każdego z tych produktów. Tworzony wtedy jest produkt bankowy klienta w tabeli `client_bank_products` zawierający wygenerowany numer rachunku `iban`, saldo `balance` i relacje do produktu bankowego `bank_product_id` oraz użytkownika - klienta `user_id`. Zastosowany mechanizm umożliwia aktywację kilku tych samych produktów bankowych przez klienta.
**Operacje**
Mechanizm aplikacji został zaprojektowany tak, że każdy przelew to operacja. Operacja może być różnego typu. Wraz z tworzoną operacją, tworzony jest powiązany przelew (relacja `belongsTo`). Zostało to tak przygotowane, gdyby operacją nie był przelew, a na przykład doładowanie telefonu (obecnie niewspierane). 

Każda nowa operacja zawiera typ operacji `operation_type_id`, informację z którego rachunku jest wykonywana `from_bank_account_id`, informację na jaki rachunek jest wykonywana `to_bank_account_id` (jeśli operacja jest między posiadanymi przez klienta rachunkami), powiązany przelew `transaction_id`, jej status `status_id` oraz zaplanowana data realizacji `scheduled_at`.

## Omówienie plików

### App
#### Controllers (app\Http)
- `BankProductsController` - kontroler zwracający metodę index(), która zwraca widok strony Produkty bankowe w panelu klienta.

#### Livewire
**Dashboard**:
- `CreateOperation` - kontroler komponentu tworzenia operacji (Kliknięcie przycisku “Nowy przelew” w panelu klienta).
- `Index` - kontroler komponentu strony głównej panelu klienta.
- `Operations` - kontroler komponentu historii operacji.
- `ShowOperationDetailsButton` - kontroler przycisku “Szczegóły” każdej operacji.
- `ShowBankProduct` - kontroler komponentu dodawania produktu bankowego przez klienta.
**Modele** (app\Models)
Zgodnie ze wzorcem MVC, każda tabela posiada w Laravelu swój Model.

#### OMÓWIENIE WAŻNIEJSZYCH METOD
**Akcesory (Accessors)** - metody zwracające preformatowane atrybuty 
**ClientBankProduct**:
- `getBalanceFrenchNotationAttribute()` — zwracająca balance sformatowany jako 0,00 zł.
- `getFormattedIbanAttribute()` — zwracająca numer rachunku sformatowany jako 00 0000 0000 0000 0000 0000 0000.
**Transaction**:
- `getFormattedAmountAttribute()` — zwracająca amount (kwotę przelewu) sformatowaną jako 0,00 zł.
- `getFormattedSenderIbanAttribute()` — zwracająca zwracająca numer rachunku nadawcy sformatowany jako 00 0000 0000 0000 0000 0000 0000.
- `getFormattedRecipientIbanAttribute()` — zwracająca zwracająca numer rachunku nadawcy sformatowany jako 00 0000 0000 0000 0000 0000 0000.
**User**:
- `getFullNameAttribute()` — zwracająca pełne imię i nazwisko (first_name + last_name)
- `getFullAddressAttribute()` — zwracająca pełny adres użytkownika (Ulica 00; 00-000 Miasto)
**View**:
- Components - w tym folderze zawarte są pliki komponentów Jetstream.
- Voyager/Widgets - pliki widżetów na głównej stronie panelu administracyjnego.
### RESOURCES
**views**/
- `api` - nieistotne dla projektu
- `auth` - widoki powiązane z autoryzacją użytkowników
- `client-panel` - widoki powiązane z panel klienta (jedna podstrona, więc tylko jeden blade)
- `components` - widoki komponentów Jetstream uruchamiane <x-nazwa-komponentu/>
- `layouts` - główny layout strony
- `livewire` - widoki komponentów Livewire wywoływane poprzez @livewire(‘...’)
- `profile` - widoki składowych edycji profilu w panelu klienta
- `vendor` - nadpisane pliki poszczególnych funkcjonalności - personalizowane widoki Voyagera i Jetstream.

## Licencja

Projekt został wrzucony w celach edukacyjnych, a także w celu stworzenia portfolio własnych projektów.

Framework Laravel jest otwartoźródłowym oprogramowaniem licencjonowanych na zasadach licencji [MIT](https://opensource.org/licenses/MIT).
