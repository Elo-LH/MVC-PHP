# Projet PHPUnit

Et vous allez avoir besoin d'installer composer : https://getcomposer.org/doc/00-intro.md#installation-windows

## Étape 0 : GitHub

Créez un repository GitHub public avec un README et appelez-le `bre01-phpunit`.

## Étape 1 : Post et PostTest

Vous allez créer une classe `Post`.

### Les attributs privés

- `$title` est une string
- `$content` est une string
- `$slug` est une string
- `$private` est un booleen

### Constructeur

Le constructeur prends tous les champs en paramètre et les initialise :

- Par défaut `$private` est `false`.

### Règles de validation

- `$title` ne peut pas être vide
- `$slug` ne peut pas être vide et ne contient que des caractères URL safe
- `$content` ne peut pas être vide

### Getters et Setters

Tous les attributs ont des getters et setters publics.

### Test

Rédigez le test unitaire pour la classe `Post`.

## Étape 2 : User et UserTest

Vous allez créer une classe `User`.

### Les attributs privés

- `$firstName` est une string
- `$lastName` est une string
- `$email` est une string
- `$password` est une string
- `$roles` est un tableau (de string)

### Constructeur

Le constructeur prends tous les champs en paramètre et les initialise :

- Par défaut `$roles` contient une seule string : `"ANONYMOUS"`.

### Règles de validation

- `$firstName` ne peut pas être vide
- `$lastName` ne peut pas être vide
- `$email` doit être une adresse email valide
- `$password` doit faire 8 caractères au minimu, contenir au moins un chiffre, une majuscule et un caractère spécial
- `$roles` doit au minimum contenir `"ANONYMOUS"`, les autres rôles possibles sont `"USER"` et `"ADMIN"`, si un `User` a `"USER"` et/ou `"ADMIN"` il ne peut plus être `"ANONYMOUS"`

### Getters et Setters

Tous les attributs ont des getters et setters publics.

### Méthodes publiques

- `addRole(string $newRole) : array` ajoute un rôle au tableau des rôles et retourne le tableau
- `removeRole(string $role) : array` retire un rôle au tableau des rôles et retourne le tableau

### Test

Rédigez le test unitaire pour la classe `User`.

## Étape 3 : Guard

Vous allez créer une classe `Guard`.

### Méthodes publiques

- `giveAccess(Post $post, User $user) : User`
- `removeAccess(Post $post, User $user) : User`

#### giveAccess

Si le Post est privé et que le User est ANONYMOUS :
une exception est levée indiquant que l'utilisateur ne peut pas être anonyme

Si le Post est privé et que le User est USER :
le User devient ADMIN

Si le Post est privé et que le User est ADMIN :
rien ne se passe

Si le Post est public et que le User est ANONYMOUS
Le User devient USER

Si le post est public et que le User est USER ou ADMIN
Rien ne se passe

#### removeAccess

Si le Post est privé et que le User est ANONYMOUS :
rien ne se passe

Si le Post est privé et que le User est USER :
le User devient ANONYMOUS

Si le Post est privé et que le User est ADMIN :
le User devient USER

Si le Post est public et que le User est ANONYMOUS
Rien ne se passe

Si le post est public et que le User est USER
Le User devient ANONYMOUS

Si le post est public et que le User est ADMIN
Le User devient USER

### Test

Rédigez le test unitaire pour la classe `Guard`.
