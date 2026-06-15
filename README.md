# 🎬 DriveIn Cinema — system zarządzania kinem samochodowym

Aplikacja webowa do kompleksowego zarządzania kinem samochodowym: planowanie repertuaru, sprzedaż i rezerwacja biletów online z przydziałem miejsc parkingowych, obsługa zamówień gastronomicznych, raporty sprzedaży oraz analiza popularności filmów.

Projekt zaliczeniowy zrealizowany w ramach przedmiotu na kierunku informatyka.

## Stos technologiczny

- **Backend:** PHP 8.2, Laravel 12
- **Frontend:** Blade, Tailwind CSS
- **Baza danych:** MySQL 8.0
- **Autoryzacja:** własna implementacja RBAC (kontrola dostępu oparta na rolach)
- **Wykresy:** Chart.js

## Główne funkcje

- Przeglądanie repertuaru i seansów
- Rezerwacja i zakup biletów online z wizualną mapą parkingu (miejsca wolne/zajęte)
- Mock płatności (karta / BLIK / przelew) — potwierdzanie rezerwacji
- Zamówienia gastronomiczne z koszykiem i śledzeniem statusu
- System opinii i ocen filmów z moderacją
- Raporty sprzedaży (bilety + gastronomia) z eksportem do CSV
- Analiza popularności filmów z wykresem słupkowym
- Algorytm optymalizacji rozmieszczenia pojazdów na parkingu wg gabarytów
- Mock powiadomień e-mail / SMS z dziennikiem
- Panel zarządzania użytkownikami (wyszukiwanie AJAX, filtrowanie, edycja, role)

## Role użytkowników

| Rola | Uprawnienia |
|------|-------------|
| **Klient** | rezerwacje, płatności, zamówienia gastronomiczne, opinie |
| **Pracownik** | obsługa zamówień gastronomicznych, optymalizacja parkingu |
| **Kierownik** | repertuar, seanse, raporty, analiza, moderacja opinii, powiadomienia |
| **Administrator** | zarządzanie kontami i uprawnieniami |
| **Partner** | rola planowana (moduł w przygotowaniu) |

## Wymagania

- PHP 8.2 z rozszerzeniami: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`
- Composer 2.x
- MySQL 8.0
- Serwer WWW (Apache / XAMPP lub Nginx)

## Instalacja

```bash
# 1. Sklonuj repozytorium
git clone <adres-repozytorium>
cd kino-app

# 2. Zainstaluj zależności
composer install

# 3. Skonfiguruj środowisko
cp .env.example .env
php artisan key:generate

# 4. Utwórz bazę danych (w phpMyAdmin lub MySQL):
#    CREATE DATABASE kino_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
#    Następnie uzupełnij dane dostępowe w pliku .env

# 5. Uruchom migracje i dane testowe
php artisan migrate
php artisan db:seed

# 6. Utwórz link do magazynu plików (wymagane do wyświetlania plakatów filmów)
php artisan storage:link

# 7. Uruchom serwer deweloperski
php artisan serve
```

Aplikacja będzie dostępna pod adresem `http://127.0.0.1:8000`.

## Konfiguracja środowiska (.env)

```env
DB_CONNECTION=mysql
DB_DATABASE=kino_app
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
```

## Konta testowe

Po wykonaniu `php artisan db:seed` dostępne są konta:

| Rola | E-mail | Hasło |
|------|--------|-------|
| Administrator | admin@kino.pl | admin123 |
| Kierownik | kierownik@kino.pl | kierownik123 |
| Pracownik | pracownik@kino.pl | pracownik123 |
| Klient | klient@kino.pl | klient123 |

## Testy

```bash
php artisan test
```

## Autorzy

- Miłosz Matuszak
- Dawid Krupski

## Licencja

Projekt udostępniony na licencji MIT — szczegóły w pliku [LICENSE](LICENSE).
