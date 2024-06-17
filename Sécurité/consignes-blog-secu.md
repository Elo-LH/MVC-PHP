# Projet Blog sécurisé


## Étape 0 : GitHub

Créez un repository GitHub public avec un README et appelez-le `bre02-secu-blog`.
Clonez-le dans le dossier `sites/php` de votre IDE.


## Étape 1 : les fichiers

Vous trouverez les fichiers du projet dans l'archive `secu-blog.zip` sur Discord.
Parcourez ces fichiers vous verrez qu'une partie des contenus vous sont déjà fournis. À vous de compléter le reste.


## Étape 2 : base de données

Sur PhpMyAdmin, créez une base de données `prenomnom_secu_blog` (en utf8_general_ci) et importez-y les fichiers SQL que vous trouverez sur Discord dans l'ordre suivant : 

1. `categories.sql`
2. `users.sql`
3. `posts.sql`
4. `posts_categories.sql`
5. `comments.sql`


## Étape 3 : les models

Faites en sorte que vos modèles soient conformes à ce qui est présent dans votre base de données. Vous devrez utiliser la composition pour représenter les jointures (par exemple, un `Post` a, entre autres, une `Category` et un `User` en attribut). 
La table `posts_categories` est une pure table de liaison, elle n'a donc pas de modèle.


## Étape 4 : les Managers

Vous allez devoir créer les managers vous permettant de manipuler votre base de données.Attention vous devez obligatoirement hydrater des instances de classes.

Voici les méthodes minimum que vous devez avoir dans vos Managers :

### CategoryManager

- `findAll()` qui retourne toutes les catégories
- `findOne(int $id)` qui retourne la catégorie qui a l'id passé en paramètre, null si elle n'existe pas

### PostManager

- `findLatest()` qui retourne les 4 derniers posts
- `findOne(int $id)` qui retourne le post qui a l'id passé en paramètre, null si il n'existe pas 
- `findByCategory(int $categoryId)` qui retourne les posts ayant la catégorie dont l'id est passé en paramètre

### CommentManager

- `findByPost(int $postId)` qui retourne les commentaires ayant le post dont l'id est passé en paramètre
- `create(Comment $comment)` qui insère le commentaire passé en paramètres dans la base de données

### UserManager

- `findByEmail(string $email)` qui retourne le user qui a l'email passé en paramètre, null si il n'existe pas
- `create(User $user)` qui insère l'utilisateur passé en paramètres dans la base de données


## Étape 5 : les Controllers

Vous allez devoir utiliser vos controllers pour afficher le contenu de vos pages et gérer la soumission de vos formulaires. Attention vous devez gérer la faille CSRF et la faille XSS pour toute information soumise par l'utilisateur.

### Sécurité

Les mots de passe doivent faire 8 caractères au minimum, avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.

Vous allez devoir utiliser une expression régulière pour cela, mon conseil, demandez à ChatGPT (ou toute autre IA) de rédiger cette expression pour vous et de vous l'expliquer. Les expressions régulières sont une syntaxe à part entière d'où ce conseil. Vous avez un bref cours sur les Regex et leu usage en PHP ici : https://elearning.3wa.fr/mod/page/view.php?id=12370. 

Les mots de passe doivent être chiffrés avec l'algorithme BCRYPT.