---
theme: theme.json
author: Gaellan
date: June 20th, 2024
paging: Page %d sur %d
---

# Multilingue : gérer les traductions en PHP

## Le principe

## Les contenus en BDD

## Les contenus statiques

## La classe de traduction

## Ajout à l'AbstractController

## L'utilisation dans les vues

---

# Gérer le multilinguisme : le principe

Les sites doivent parfois s'addresser à des publics multiples, qui utilisent différents langages. Si sur un petit site statique on peut se contenter de créer des doublons de page HTML en fonction de la langue, c'est beaucoup plus difficile sur des sites plus gros, avec du contenu dynamique.

On met donc en place différentes stratégies pour permettre de gérer le multilinguisme et de rajouter au besoin des nouvelles langues.

Il faut gérer la traduction de deux types de contenus : les contenus statiques (label des formulaires, messages de confirmations, titres des pages, ...) et les contenus dynamiques (ceux stockés dans la base de données).

---

# Traduire les contenus en BDD

Il existe de multiples stratégies pour la traduction des contenus stockés dans une base de données, je vais vous en présenter une simple. Gardez simplement à l'esprit que ça n'est pas la seule.

## Une table monolingue

Imaginons que vous avez une table qui contient les noms et descriptions de catégories de livres :

| id | name           | description          |
|----|----------------|----------------------|
|   1| policier       | crimes et enquêtes   |
|   2| fantastique    | elfes, nains et orcs |
|   3| science-fiction| aliens et espace     |   

## Et sa version multilingue

Imaginons maintenant que vous souhaitez que votre site soit disponible à la fois en français et en anglais

| id | name_fr        | description_fr       | name_en         | description_en             |
|----|----------------|----------------------|-----------------|----------------------------|
|   1| policier       | crimes et enquêtes   | thriller        | crimes and investigations  |      
|   2| fantastique    | elfes, nains et orcs | heroic-fantasy  | elves, dwarves and orcs    |      
|   3| science-fiction| aliens et espace     | science-fiction | aliens and space           |

Vous devez traduire tous les champs de la base qui seront affichés sur les vues. 

---

# Traduire les contenus statiques

Pour vos contenus statiques, la stratégie est un peu différente, vous allez créer des fichiers `.json` de traduction des textes que vous utilisez.

## Un formulaire de login

```html
<form>
    <label for="username">
        Nom d'utilisateur
    </label>
    <input type="text" name="username" id="username" />
    <label for="password">
        Mot de passe
    </label>
    <input type="password" name="password" id="password" />
    <button type="submit">Connexion</button>
</form>
```

## Le fichier des textes en français

`auth_fr.json`:

```json
{
    "login_username_label" : "Nom d'utilisateur",
    "login_password_label" : "Mot de passe",
    "login_submit_button" : "Connexion"
}
```

## Le fichier des textes en anglais

`auth_en.json`:

```json
{
    "login_username_label" : "Username",
    "login_password_label" : "Password",
    "login_submit_button" : "Login"
}
```

---

# La classe de traduction

On créé ensuite un Service (donc une classe utile qui n'est ni un Model, ni un Manager, ni un Controller) qui va gérer les traductions.

```php
class Translator 
{

    public function __construct(private string $file, private string $lang, private array $translations = [])
    {
        $this->loadTranslations();
    }

    private function loadTranslations() : void 
    {
        $filePath = "./translations/{$this->file}_{$this->lang}.json";
        $this->translations = json_decode(file_get_contents($filePath), true);
    }

    public function translate(string $key)
    {
        if(isset($this->translations[$key]))
        {
            return $this->translations[$key];
        }
        else
        {
            return $key;
        }
    }
}
```

---

# Ajout à l'AbstractController

Comme ce traducteur sera utilisé sur toutes nos pages, et qu'une route === une méthode de controller nous allons faire en sorte qu'il soit disponible dans chacun de nos controllers.

```php
abstract class AbstractController
{
    protected Translator $translator;

    public function __construct(string $file, protected string $currentLang = "fr")
    {
        $this->translator = new Translator($file, $this->currentLang);
    }
}
```

Nos controllers vont ensuite hériter de l'`AbstractController` :

```php
class AuthController extends AbstractController
{
    public function __construct()
    {
        $lang = $_SESSION["lang"];

        parent::__construct("auth", $lang);
    }

    public function getTranslator() : Translator
    {
        return $this->translator;
    }
}
```

Avec cette stratégie, vous devez avoir un fichier de traduction par controller et par langue. Donc si vous avez un `BlogController` et un `AuthController` et que vous gérez le français et l'anglais, vous aurez 4 fichiers :

- `auth_en.json`
- `auth_fr.json`
- `blog_en.json`
- `blog_fr.json`

---

# L'utilisation dans les vues

Une fois que vous avez mis tout ça en place, vous allez utiliser le Translator disponible dans votre Controller :

```html
<form>
    <label for="username">
        <?= $this->getTranslator()->translate("login_username_label") ?>
    </label>
    <input type="text" name="username" id="username" />
    <label for="password">
        <?= $this->getTranslator()->translate("login_password_label") ?>
    </label>
    <input type="password" name="password" id="password" />
    <button type="submit"><?= $this->getTranslator()->translate("login_submit_button") ?></button>
</form>
```

---

# Exercice : traduction de formulaires

Les consignes sont disponibles dans le fichier `consignes-translate-form.md` sur Discord.

---

# Projet : traduction du Secure Blog

Faites en sorte que le blog réalisé pour le cours sur la sécurité soit disponible en anglais et en français. Pour traduire les contenus, demandez de l'aide à ChatGPT ou l'IA de votre choix.

Vous pouvez trouver une correction du projet à l'adresse suivante : https://github.com/Gaellan/bre01-blog-secu.

Récupérez ces fichiers si vous ne l'aviez pas fini. Recopiez également les tables de la base de données dans une nouvelle base.
