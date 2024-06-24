---
theme: theme.json
author: Gaellan
date: Feb 20, 2024
paging: Page %d sur %d
---

# Les tests en PHP

## Les exceptions

## Tests Unitaires

## Tests Structurels

## Tests fonctionnels

## La couverture des tests

## PHP Unit

## Exercice tests unitaires


Si le sujet des tests vous intéresse, une très bonne ressource francophone : https://latavernedutesteur.fr/.

---

# try, catch et Exception

En PHP si l'on veut pouvoir capter les potentielles erreurs du code pour y réagir, on utilise les try, les catch et les Exceptions.

Dans sa version la plus simple, le bloc `try` tente d'exécuter un bout de code, si une erreur survient, c'est `catch` qui l'attrape au vol et permet, par exemple d'afficher le message d'erreur :

```php
try {
    $db = new PDO();
}
catch(Exception $e)
{
    echo $e->getMessage();
}
```

Si dans le cadre de votre gestion d'erreurs vous avez besoin de signaler une erreur vous pouvez `throw` une Exception :

```php
function divide($nb1, $nb2)
{
    if($nb2 === 0)
    {
        throw new Exception("Dividing by 0");
    }

    return $nb1 / $nb2;
}
```

La documentation des Exceptions : https://www.php.net/manual/fr/language.exceptions.php

---
# Les types de tests

## Les tests unitaires

L'idée est simple : un test unitaire s'occupe de tester une unité du code. En POO : une classe => un test unitaire de cette classe.

Le test va vérifier que tous les cas se déroulent comme attendu. Constructeurs, Getters, Setters, etc. La classe doit faire son travail quand tout va bien et lever la bonne Exception quand quelque chose lui déplait.

En PHP, la librairie qui permet de réaliser des tests unitaires s'appelle PHPUnit.

## Les tests structurels

Un test structurel par contre test en niveau plus macro, il va tester une fonctionnalité entière, toujours côté code, mais il va tester chaque étape pour statuer à la fin si chacune de ses étapes fonctionne et si ces étapes fonctionnent entre elles.

## Les tests fonctionnels

Les tests fonctionnels eux se placent plutôt du côté de l'utilisateur, on rédige un scénario de comment les choses devraient se passer, et on vérifie que tout se passe comme prévu, à la fois les cas de succès et les cas d'erreurs.

Behat, la principale technologie de tests fonctionnels a une implémentation PHP.

---

# La couverture des tests

La couverture des tests c'est la portion des blocs de votre code qui sont couverts par vos tests. On divise le code en portion, et lorsque cette portion est intégralement parcourue par les tests on considère qu'elle est couverte.

```php

$currentYear = false;
$pastYear = false;
$futureYear = false;

if($year === 2023)
{
    $currentYear = true;
}
else if($year > 2023)
{
    $futureYear = true;
}
else
{
    $pastYear = true;
}
```

- Si je ne teste qu'avec 2023 => je ne couvre que le if
- Si je ne teste qu'avec 2024 => je ne couvre que le else if
- Si je ne teste qu'avec 2022 => je ne couvre que le else

Un test qui essaierai à la fois 2023, 2024 et 2022 permettrait théoriquement une couverture de 100%.

## 🚨 Méfiance

Dans l'exemple ci-dessus on teste bien les trois cas du code, mais on omet complètement de tester par exemple que l'on nous envoie le bon type, dans l'exemple, envoyer "2023" nous ferait passer dans le else. La couverture de tests c'est donc un bon indicateur mais ça n'est pas la seule chose à surveiller.

---

# PHP Unit

PHPUnit est une librairie permettant de réaliser des test unitaires en PHP.

Vous pouvez l'installer via composer :

```sh
composer require --dev phpunit/phpunit ^10
```

Vous devrez créer deux dossiers : `src` qui contiendra vos sources et `tests` qui contiendra vos tests.

Votre `composer.json` devrait ressembler à ça :

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

Pour lancer les tests : 

```sh
./vendor/bin/phpunit --testdox tests
```

---

# Exercice tests unitaires

Les consignes à suivre pour voir comment fonctionne PHPUnit sont disponibles dans le fichier `exercices-unit-tests.md` sur Discord.

---

# Mini-projet PHPUnit

Les consignes du mini-projet PHPUnit sont disponibles dans le fichier `projet-unit-tests.md` sur Discord.
