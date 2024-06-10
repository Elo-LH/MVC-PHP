# Exercice Routeur MVC

## Étape 0 : GitHub

Créez un repository GitHub public avec un README et appelez-le : `bre01-routeur-mvc`.
Clonez le dans le dossier `sites/php` de votre IDE.

## Étape 1 : Créer les fichiers

Dans le dossier de votre projet recréez l'architecture de dossiers suivante :

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

💡 Pour que Git conserve votre architecture de dossiers, créez des fichiers vides appellés `.gitkeep` dans vos dossiers vides.


## Étape 2 : le Routeur

Dans le fichier `config/Router.php` vous allez créer une classe `Router`.

Cette classe n'a pas d'attributs, son constructeur n'initialise rien, mais elle a par contre une méthode publique : `handleRequest(array $get) : void`.

Dans cette méthode `handleRequest` vous allez créer des conditions :

Si `$get["route"]` existe et vaut `"a-propos"`.
Si `$get["route"]` n'existe pas.
Dans tous les autres cas.

Pour l'instant laissez du vide entre les accolades de ces conditions nous allons les remplir plus tard.


## Étape 3 : Le controlleur

Créez un fichier `controllers/PageController.php` dans lequel vous allez créer une classe `PageController`.

`PageController` n'a pas d'attributs mais a 3 méthodes publiques :

- `home() : void`
- `about() : void`
- `404() : void`

### home()

Définit une variable `$route` et lui donne la valeur `"home"` puis require le fichier `templates/layout.phtml`.

### about()

Définit une variable `$route` et lui donne la valeur `"about"` puis require le fichier `templates/layout.phtml`.

### 404()

Définit une variable `$route` et lui donne la valeur `"404"` puis require le fichier `templates/layout.phtml`.


## Étape 4 : compléter le Router

Vous allez maintenant compléter les conditions de votre `Router` pour faire que :

- Si `$get["route"]` vaut `a-propos` : vous créez une instance du `PageController` et appelez sa méthode `about`
- Si `$get["route"]` n'existe pas : : vous créez une instance du `PageController` et appelez sa méthode `home`
- Dans tous les autres cas : vous créez une instance du `PageController` et appelez sa méthode `404`


## Étape 5 : les templates

### layout.phtml

Voici le contenu de base de `layout.phtml` :

```html
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Exercice Routeur MVC</title>
	</head>
	<body>
		<header>
			<nav>
				<ul>
					<li>
						<a href="index.php">Accueil</a>
					</li>
					<li>
						<a href="index.php?route=a-propos">À propos</a>
					</li>
				</ul>
			</nav>
		</header>
		<?php
			// votre code ici
		?>
	</body>
</html>
```

Dans les balises PHP faites en sorte que :

- si `$route` vaut `home` : require le fichier `templates/home.phtml`
- si `$route` vaut `about` : require le fichier `templates/about.phtml`
- si `$route` vaut `404` : require le fichier `templates/404.phtml`

### home.phtml

Vous allez devoir créer un nouveau fichier `templates/home.phtml` avec le contenu suivant :

```html
<main>
	<h1>Page d'accueil</h1>
</main>
```

### about.phtml

Vous allez devoir créer un nouveau fichier `templates/about.phtml` avec le contenu suivant :

```html
<main>
	<h1>Page à propos</h1>
</main>
```

### 404.phtml

Vous allez devoir créer un nouveau fichier `templates/404.phtml` avec le contenu suivant :

```html
<main>
	<h1>404 : Page introuvable</h1>
</main>
```

### contact.phtml

Vous allez devoir créer un nouveau fichier `templates/contact.phtml` avec le contenu suivant :

```html
<main>
	<h1>Page de contact</h1>
</main>
```

## Étape 6 : l'autoload

Dans votre fichier `config/autoload.php` fite un require de votre `PageController` et de votre `Router`.

## Étape 7 : l'index

Dans votre fichier `index.php` faites un require de votre `config/autoload.php`, instanciez un `Router` et passez la superglobale `$_GET` à la méthode `handleRequest` du routeur.

## Étape 8 : une nouvelle route

Maintenant à vous de jouer : créez une nouvelle route, qui si l'URL demandée est `index.php?route=contact` affichera la page de contact.