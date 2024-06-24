# Exercice tests unitaires

Cet "exercice" est une traduction de l'exemple de base de la documentation de PHPUnit.

## Étape 0 : Créer les dossiers

Créez un dossier `ex-phpunit`.

Dans ce dossier créez un dossier `src` et un dossier `tests`.

## Étape 1 : composer

Nous allons indiquer à composer que nous allons utiliser PHPUnit :

```sh
composer require --dev phpunit/phpunit ^10
```

Le fichier `composer.json` généré doit ressembler à ceci :

```json
{
    "require-dev": {
        "phpunit/phpunit": "^10"
    }
}
```

Modifiez-le pour qu'il ressemble à ceci :

```json
{
    "autoload": {
        "classmap": [
            "src/"
        ]
    },
    "require-dev": {
        "phpunit/phpunit": "^10"
    }
}
```

## Étape 2 : Créer la source

Dans le dossier `src`, créez un fichier `Email.php`, dans lequel vous mettrez le code suivant :

```php
<?php 

declare(strict_types=1);

class Email
{
    private string $email;

    private function __construct(string $email)
    {
        $this->ensureIsValidEmail($email);

        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function asString(): string
    {
        return $this->email;
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address',
                    $email
                )
            );
        }
    }
}
```

## Étape 3 : Créez le test

Dans le dossier `tests`, créez un fichier `EmailTest.php`, dans lequel vous mettrez le code :

```php

<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testCanBeCreatedFromValidEmail(): void
    {
        $string = 'user@example.com';

        $email = Email::fromString($string);

        $this->assertSame($string, $email->asString());
    }

    public function testCannotBeCreatedFromInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }
}

```
## Étape 4 : générer l'autoload

Pour précharger vos classes faites la commande suivante :

```sh
composer dump-autoload
```

## Étape 5 : Executez le test

Pour exécuter les tests faites la commande suivante :

```sh
./vendor/bin/phpunit --testdox tests
```