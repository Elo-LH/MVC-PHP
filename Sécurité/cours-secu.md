---
theme: theme.json
author: Gaellan
date: June 17, 2024
paging: Page %d sur %d
---

# Les principales failles de sécurité en PHP

## Injection SQL

## Faille XSS

## Authentification faible

## Pas de protection des routes

## Faille CSRF

---

# Les injections SQL

## Le principe

Une injection SQL c'est le fait d'utiliser des champs de formulaires ou des paramètres GET pour faire exécuter du SQL qui fera des transactions non prévues.

On peut comme ça supprimer ou altérer une base de données ou bien tout simplement voler des données d'utilisateurs.

## La solution

La bonne nouvelle c'est que si vous appliquez les consignes du cours sur le SQL vous gérez déjà ce problème.

Lorsque vous utilisez des paramètrs pour préparer vos requêtes SQL, PDO fait le travail pour vous et vire tous les caractères nuisibles qui pourraient s'y trouver.

⛔️ À ne pas faire ⛔️

```php
$query = $this->db->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);  
$query->execute();
```

✅ À faire ✅

```php
$query = $this->db->prepare("SELECT * FROM categories WHERE id=:id");  
$parameters = [  
   "id" => $_GET["id"]  
];  
$query->execute($parameters);
```

---

# Les failles XSS

## Le principe

La faille XSS c'est le fait de permettre à un utilisateur d'envoyer du JavaScript ou du HTML via les formulaires.

Une fois que votre PHP injecte le code dans la page celui-ci peut s'exécuter et donc poser de gros soucis (appel à une API, désactivation du site, redirection sauvage etc etc).

## La solution

À partir du moment où vous injectez en PHP des valeurs dont vous ne maitrisez pas la provenance (donc pas des valeurs entrées par des personnes sûres depuis un espace sécurisé) vous devez demander à PHP de transformer les caractères spéciaux pour qu'ils ne posent plus problème.

Pour faire cela on utilise la fonction `htmlspecialchars` (https://www.php.net/manual/fr/function.htmlspecialchars.php).

Elle s'utilise ainsi : 

```php
$unsafeCode = "<script>alert('toto');</script>";
$safeCode = htmlspecialchars($unsafeCode);
```

Une fois passée dans `htmlspecialchars` notre string `$safeCode` vaut :

```php
"&lt;script&gt;alert(&#039;toto&#039;);&lt;/script&gt;"
```

Et si vous faites un 

```php
echo $safeCode;
```

vous obtiendrez :

```txt
<script>alert('toto');</script>
```

considéré comme du simple texte et pas exécuté.

---

# L'authentification faible

Une authentification faible c'est une authentification qui n'a pas de chiffrement ou un chiffrement trop léger.

## Pas de chiffrement

Pas de chiffrement, c'est si vous stockez des mots de passe en clair dans la base de données, si vous ne limitez pas le nombre d'essai, un script finira par trouver les mots de passe.

Et si jamais pour une raison ou une autre vos données fuitent, n'importe qui peut accéder à n'importe quel compte.

## Chiffrement faible

Chiffrement trop faible cela veut dire que vous utilisez un algorithme de chiffrement dont on sait qu'il a déjà été craqué. Par défaut dans PHP c'est bcrypt qui est utilisé, bcrypt est pour l'instant considéré comme fiable (il est long à déchiffrer) et vous protège plutôt bien.

Par contre attention à ne pas autoriser des mots de passe trop faibles : exigez un nombre minimal de caractères, des minuscules, majuscules, chiffres et caractères spéciaux.

![Temps de résistance des mots de passe](https://maridoucet.sites.3wa.io/assets/2023-passwords.png)

---

# La protection des routes

## Le principe

Imaginez que vous ayez bien une authentification qui marche, vous avez des utilisateurs tout va bien.

Dans les routes de votre site vous avez une route : 

https://dieuxducode.com/utilisateur/4/infos 

Qui permet à un utilisateur connecté de voir les infos de son compte.

Dans votre Controlleur vous vérifiez avant d'afficher cette page que l'utilisateur est bien connecté et ensuite vous l'affichez.

Que se passerait il si l'utilisateur 4, connecté, changeait l'URL pour demander l'URL :

https://dieuxducode.com/utilisateur/5/infos

Il verrait toutes les infos de l'utilisateur 5.

## La solution

Pour pallier à ce problème la solution est simple, faire une vérification dans le Controlleur que l'utilisateur est bien connecté ET qu'il s'agit bien de l'utilisateur 4.

## Bonus

Vous pouvez éventuellement rajouter une dose de sécurité en utilisant non pas des id directement dans vos routes mais des uuid, des identifiants uniques plus longs et plus complexes, par exemple à l'aide de la fonction `uniqid()` (https://www.php.net/manual/en/function.uniqid.php).

🚨  `uniqid()` seule ne peut pas garantir un id unique, mais vous pouvez par exemple concaténer votre id classique de base de données avec le retour de `uniqid` cela améliorera grandement vos chances : 

```php
$uuid = uniqid($id, true);
```

---

# Les failles CSRF

## Le principe

La faille CSRF (Cross Site Request Forgery) se produit lorsqu'un site malveillant profite des informations isponibles dans vos cookies par exemple pour se faire passer pour vous auprès d'autres sites, sans que vous en ayez conscience. Le site malveillant utilise les données de votre session pour se faire passer pour vous sur le site de votre banque, votre boite mail, etc etc et effectuer des opérations en votre nom.

## La solution

Il existe plusieurs solutions possibles qui peuvent s'additionner, mais le principale est l'utilisation de tokens pour chaque requête et chaque formulaire. Vous générez un token unique par session d'utilisateur et à chaque fois qu'une requête API ou un formulaire est envoyé par cet utilisateur vous ajoutez un champ caché avec ce token.

### Générer un token

```php
function generateCSRFToken() : string
{
    $token = bin2hex(random_bytes(32));
    
    return $token;
}
```

### Vérifier un token

```php
function validateCSRFToken($token) : bool
{
    
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) 
    {
        return true;
    }
    else 
    {
        return false;
    }
}
```

---

# Projet d'application : le retour du blog

Pour appliquer toutes ces notions nous allons utiliser un exemple que nous commençons à bien connaitre : un blog. 

Vous trouverez les consignes du projet dans le fichier `consignes-blog-secu.md` sur Discord.




