# Mini-projet Blog MVC

## GitHub

Créez un repository public GitHub avec un README et appelez le `bre01-blog-mvc`.
Clonez-le dans le dossier `sites/php` de votre IDE.


## Base de données 

Vous allez réutiliser la base de données appellée `prenomnom_blog_poo` que vous aviez utilisée pour le projet de blog en POO.


## Les consignes

### Les routes

- pas de route amène vers la page d'accueil qui liste les deux derniers posts de chaque catégorie
- `route=categories` amène sur une page qui liste les catégories
- `route=category&category=id_category` amène sur la page d'une catégorie (qui liste les posts de cette catégorie)
- `route=post&post=post_id` amène vers la page d'un post (qui affiche le contenu de ce post)

### Les Models

Chacune de vos tables de données aura un `Model` dans votre projet :

- `users`
- `categories`
- `posts`

### Les Managers

Chacun de vos `Models` aura un `Manager` correspondant, qui hérite d'un `AbstractManager`:

- `UserManager`
- `PostManager`
- `CategoryManager`

### Les Controllers

Vous aurez 3 controllers :

- `PageController` qui gère la page d'accueil et les pages 404 (si la route n'existe pas, la catégorie n'existe pas ou le post n'existe pas)
- `CategoryController` qui gère la page de liste des catégories et la page de détail d'une catégorie
- `PostController` qui gère la page de détail d'un post


## Bonus :

### Authentification

Gérer une inscription et une authentification

### Espace d'administration

Créer un espace d'administration qui permet de lister / créer / modifier / supprimer des utilisateurs, des posts et des catégories



