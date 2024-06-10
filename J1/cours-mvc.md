---
theme: theme.json
author: Gaellan
date: Jan 31, 2024
paging: Page %d sur %d
---

# LE MVC

## Qu'est-ce que le MVC ?

## Les Models

## Les Managers

## Les Views

## Les Controllers

## Le Routeur

## Les Services

---

# Qu'est-ce que le MVC ?

Le MVC (Model View Controller) est un design pattern, une architecture de code particulièrement adaptée au web.

Le MVC repose sur la stricte séparation entre les pages (View), les données (Models) et la logique (Controller).

Utilisé avec la POO, le MVC permet un code propre bien organisé, souple et plus facile à maintenir et faire évoluer.

## Déroulement de l'appel à une page en MVC

Le fonctionnement typique de l'appel d'une page en MVC est donc le suivant :

1. Votre utilisateur demande à son navigateur la page de votre site : _http://example.com/index.php?route=login_
2. Votre `index.php`reçoit la requête et instancie votre class `Router`
3. Votre `index.php` transmet la requête à votre `Router`
4. Le `Router` vérifie si la route `login` existe, et instancie le controlleur approprié (`LoginController`)
5. Le `Router` appelle la méthode appropriée du controlleur : `LoginController::login()`
6. La méthode `login` prépare le nom du template à charger et appelle `layout.phtml`
7. `layout.phtml` appelle le template `login.phtml`
8. Votre utilisateur voit sa page s'afficher

---

# Les Models

Une classe `Model` est une classe qui représente une des tables de votre base de données. Chaque instance d'un `Model` correspond à une ligne de la table correspondante.

## Exemple

Prenons l'exemple d'une classe qui représente un utilisateur :

```php
class User 
{
    private ? int $id = null;

    public function __construct(private string $email, private string $password){}

    public function getId() : ? int 
    {
        return $this->id;
    }

    public function setId(int $id) : void 
    {
        $this->id = $id;
    }

    public function getEmail() : string 
    {
        return $this->email;
    }

    public function setEmail(string $email) : void 
    {
        $this->email = $email;
    }

    //...
}
```

---

# Les Managers

Un `Manager` est une classe qui va faire l'interface entre l'un de vos `Model` et la base de données. On considère généralement qu'il y a un `Manager` par `Model`. Certains frameworks (dont Symfony) appellent les managers des `Repository`.

Par défaut un managers doit permettre d'effectuer 5 actions et donc contenir 5 méthodes :

- `findAll()` qui récupère toute les données de la table et les retournent dans un tableau d'instances du `Model`
- `findOne(int $id)` qui récupère une ligne de la table et la retourne dans une instance du `Model`
- `create(Model $model)` qui créée le `Model` reçu en paramètres dans la base de données
- `update(Model $model)` qui sauvegarde le `Model` reçu en paramètres dans la base de données
- `delete(Model $model)` qui supprime le `Model` reçu en paramètres

Elle peut en contenir d'autres, si vous avez des requêtes que vous ave systématiquement besoin d'effectuer, par exemple trouver tous les `Models` selon un critère autre que l'id.

---

# Les Views

Les views se sont vos templates, donc vos fichiers `.phtml`.

La structure de base de votre page avec les inclusions de vos CSS et JS se fait dans un fichier `layout.phtml` qui lui même appelera les bons templates en fonction de ce dont votre page a besoin.

Si vous avez deux interface différentes : par exemple un site et son interface d'administration, vous aurez deux layouts différents ci-besoin.

---

# Les Controllers

Vos `Controllers` contiennent toute la logique de votre site.

En MVC, une route = une méthode de `Controller`.

Un `Controller` va généralement correspondre à une fonctionnalité.

Par exemple :

- `?route=login` et `?route=register` correspondront aux méthodes `AuthController::login()` et  `AuthController::register()` respectivement.
- `?route=list-users` et `?route=show-user` aux méthodes `UserController::list()` et `UserController::show()` respectivement.
- ...

Une méthode de `Controller` prépare les données pour l'affichage (en appelant un `Manager` par exemple), précise au layout le template qui devra être appelé et traite les formulaires quand ils ont été soumis.

---

# Le Routeur

Le `Router` est une classe donc le rôle est de faire correspondre les routes dans les URLs (`?route=bidule`) à la bonne méthode de `Controller`.

Si aucune méthode ne correspond, la route n'existe pas et il doit appeler une méthode de `Controller` qui affichera une page 404.

---

# Les Services

Un `Service` est une classe qui remplit une fonction précise et peut avoir besoin d'être appelée par plusieurs `Controllers` différents.

Par exemple : une classe qui se charge d'envoyer des mails, ou une classe qui se charge d'uploader des fichiers.

---

# Structure de base des fichiers d'un projet MVC

```sh
- assets
    - styles
        - css
        - scss
    - js
- config
    - Router.php
    - autoload.php
- controllers
- models
- services
- templates
    - layout.phtml
- index.php
```

À partir de ce point du cours, tous vos projets seront contenus dans des classes, vous pouvez donc utiliser des fichiers `.php` au lieu de `.class.php` pour écrire vos classes.

Le fichier `autoload.php` vous sert à faire un `require` de toutes vos classes, vous pouvez ensuite `require` ce fichier en haut de votre `index.php` et vos classes seront toujours disponibles.

---

# Exercice : Mise en place d'un routeur MVC

Dans le fichier `consignes-routeur-mvc.md` sur Discord.

---

# Exercice : Mise en place d'une authentification MVC

Dans le fichier `consignes-authentification-mvc.md` sur Discord.

---

# Exercice bonus : Upload de fichiers en MVC

Dans le fichier `consignes-upload-mvc.md` sur Discord.
