<?php
require_once "../model/NewsWeb/Trait/SlugifyTrait.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Slugify-meeeeeeeeeeeeeeee</h1>
<form action="" method="post" name="lulu">
    <input type="text" name="toslug" size="40">
    <input type="submit" value="slug me too much">
    <?php
    if (isset($_POST['toslug'])):
        ?>
        <textarea rows="15" cols="30"><?= \NewsWeb\Trait\SlugifyTrait::slugify($_POST['toslug']) ?></textarea>
    <?php
    endif;
    ?>
</form>
</body>
</html>
La programmation orientée objet (POO), ou programmation par objet, est un paradigme de programmation informatique.

Elle consiste en la définition et l'#039;interaction de briques logicielles appelées objets ; un objet représente un concept, une idée ou toute entité du monde physique, comme une voiture, une personne ou encore une page d'#039;un livre.

Il possède une structure interne et un comportement, et il sait interagir avec ses pairs. Il s'#039;agit donc de représenter ces objets et leurs relations ; l'#039;interaction entre les objets via leurs relations permet de concevoir et réaliser les fonctionnalités attendues, de mieux résoudre le ou les problèmes.

Dès lors, l'#039;étape de modélisation revêt une importance majeure et nécessaire pour la POO. C'#039;est elle qui permet de transcrire les éléments du réel sous forme virtuelle.

La programmation par objet consiste à utiliser des techniques de programmation pour mettre en œuvre une conception basée sur les objets.

Celle-ci peut être élaborée en utilisant des méthodologies de développement logiciel objet, dont la plus connue est le processus unifié (« Unified Software Development Process » en anglais), et exprimée à l'#039;aide de langages de modélisation tels que le Unified Modeling Language (UML).

La programmation orientée objet est facilitée par un ensemble de technologies dédiés :

les langages de programmation (chronologiquement : Simula, LOGO, Smalltalk, Ada, C++, Objective C, Eiffel, Python, PHP, Java, Ruby, AS3, C#, VB.NET, Fortran 2003, Vala, Haxe, Swift) ;
les outils de modélisation qui permettent de concevoir sous forme de schémas semi-formels la structure d'#039;un programme (Objecteering, UMLDraw, Rhapsody, DBDesigner…) ;
les bus distribués (DCOM, CORBA, RMI, Pyro…) ;

les ateliers de génie logiciel ou AGL (Visual Studio pour des langages Dotnet, NetBeans ou Eclipse pour le langage Java).
Il existe actuellement deux grandes catégories de langages à objets :

les langages à classes, que ceux-ci soient sous forme fonctionnelle (Common Lisp Object System), impérative (C++, Java) ou les deux (Python, OCaml) ;
les langages à prototypes (JavaScript, Lua).

En implantant les Record Class de Hoare, le langage Simula 67 pose les constructions qui seront celles des langages orientés objet à classes : classe, polymorphisme, héritage, etc. Mais c'#039;est réellement par et avec Smalltalk 71 puis Smalltalk 80, inspiré en grande partie par Simula 67 et Lisp, que les principes de la programmation par objets, résultat des travaux d'#039;Alan Kay, sont véhiculés : objet, encapsulation, messages, typage et polymorphisme (via la sous-classification) ; les autres principes, comme l'#039;héritage, sont soit dérivés de ceux-ci ou une implantation. Dans Smalltalk, tout est objet, même les classes. Il est aussi plus qu'#039;un langage à objets, c'#039;est un environnement graphique interactif complet.

À partir des années 1980, commence l'#039;effervescence des langages à objets : C++ (1983), Objective-C (1984), Eiffel (1986), Common Lisp Object System (1988), etc. Les années 1990 voient l'#039;âge d'#039;or de l'#039;extension de la programmation par objets dans les différents secteurs du développement logiciel.

Depuis, la programmation par objets n'#039;a cessé d'#039;évoluer aussi bien dans son aspect théorique que pratique et différents métiers et discours mercatiques à son sujet ont vu le jour :

l'#039;analyse objet (AOO ou OOA en anglais) ;
la conception objet (COO ou OOD en anglais) ;
les bases de données objet (SGBDOO) ;
les langages objets avec les langages à prototypes ;
ou encore la méthodologie avec MDA (Model Driven Architecture).
Aujourd'#039;hui, la programmation par objets est vue davantage comme un paradigme, le paradigme objet, que comme une simple technique de programmation. C'#039;est pourquoi, lorsque l'#039;on parle de nos jours de programmation par objets, on désigne avant tout la partie codage d'#039;un modèle à objets obtenu par AOO et COO.

La programmation orientée objet a été introduite par Alan Kay avec Smalltalk. Toutefois, ses principes n'#039;ont été formalisés que pendant les années 1980 et, surtout, 1990. Par exemple le typage de second ordre, qui qualifie le typage de la programmation orientée objet (appelé aussi duck typing), n'#039;a été formulé qu'#039;en 1995 par Cook.

Concrètement, un objet est une structure de données qui répond à un ensemble de messages. Cette structure de données définit son état tandis que l'#039;ensemble des messages qu'#039;il comprend décrit son comportement :

les données, ou champs, qui décrivent sa structure interne sont appelées ses attributs ;
l'#039;ensemble des messages forme ce que l'#039;on appelle l'#039;interface de l'#039;objet ; c'#039;est seulement au travers de celle-ci que les objets interagissent entre eux. La réponse à la réception d'#039;un message par un objet est appelée une méthode (méthode de mise en œuvre du message) ; elle décrit quelle réponse doit être donnée au message.
Certains attributs et/ou méthodes (ou plus exactement leur représentation informatique) sont cachés : c'#039;est le principe d'#039;encapsulation. Ainsi, le programme peut modifier la structure interne des objets ou leurs méthodes associées sans avoir d'#039;impact sur les utilisateurs de l'#039;objet.

Un exemple avec un objet représentant un nombre complexe : celui-ci peut être représenté sous différentes formes (cartésienne (réel, imaginaire), trigonométrique, exponentielle (module, angle)). Cette représentation reste cachée et est interne à l'#039;objet. L'#039;objet propose des messages permettant de lire une représentation différente du nombre complexe. En utilisant les seuls messages que comprend notre nombre complexe, les objets appelants sont assurés de ne pas être affectés lors d'#039;un changement de sa structure interne. Cette dernière n'#039;est accessible que par les méthodes des messages.

Dans la programmation par objets, chaque objet est typé. Le type définit la syntaxe (« Comment l'#039;appeler ? ») et la sémantique des messages (« Que fait-il ? ») auxquels peut répondre un objet. Il correspond donc, à peu de chose près, à l'#039;interface de l'#039;objet. Toutefois, la plupart des langages objets ne proposent que la définition syntaxique d'#039;un type (C++, Java, C#…) et rares sont ceux qui fournissent aussi la possibilité de définir formellement sa sémantique (comme dans le langage Eiffel avec sa conception par contrats).

Un objet peut appartenir à plus d'#039;un type : c'#039;est le polymorphisme ; cela permet d'#039;utiliser des objets de types différents là où est attendu un objet d'#039;un certain type. Une façon de réaliser le polymorphisme est le sous-typage (appelé aussi héritage de type) : on raffine un type-parent en un autre type (le sous-type) par des restrictions sur les valeurs possibles des attributs. Ainsi, les objets de ce sous-type sont conformes au type parent. De ceci découle le principe de substitution de Liskov. Toutefois, le sous-typage est limité et ne permet pas de résoudre le problème des types récursifs (un message qui prend comme paramètre un objet du type de l'#039;appelant). Pour résoudre ce problème, Cook définit en 1995 la sous-classification et le typage du second ordre qui régit la programmation orientée objet : le type est membre d'#039;une famille polymorphique à point fixe de types (appelée classe). Les traits sont une façon de représenter explicitement les classes de types. (La représentation peut aussi être implicite comme avec Smalltalk, Ruby, etc.).

On distingue dans les langages objets deux mécanismes du typage :

le typage dynamique : le type des objets est déterminé à l'#039;exécution lors de la création desdits objets (Smalltalk, Common Lisp, Python, PHP…) ;
le typage statique : le type des objets est vérifié à la compilation et est soit explicitement indiqué par le développeur lors de leur déclaration (C++, Java, C#, Pascal…), soit déterminé par le compilateur à partir du contexte (Scala, OCaml…).
De même, deux mécanismes de sous-typage existent : l'#039;héritage simple (Smalltalk, Java, C#) et l'#039;héritage multiple (C++, Python, Common Lisp, Eiffel, WLangage).

Le polymorphisme ne doit pas être confondu avec le sous-typage ou avec l'#039;attachement dynamique (dynamic binding en anglais).

La programmation objet permet à un objet de raffiner la mise en œuvre d'#039;un message défini pour des objets d'#039;un type parent, autrement dit de redéfinir la méthode associée au message : c'#039;est le principe de redéfinition des messages (ou overriding en anglais).

Or, dans une définition stricte du typage (typage du premier ordre), l'#039;opération résultant d'#039;un appel de message doit être la même quel que soit le type exact de l'#039;objet référé. Ceci signifie donc que, dans le cas où l'#039;objet référé est de type exact un sous-type du type considéré dans l'#039;appel, seule la méthode du type père est exécutée :

Soit un type Reel contenant une méthode * faisant la multiplication de deux nombres réels, soient Entier un sous-type de Reel, i un Entier et r un Reel, alors l'#039;instruction i * r va exécuter la méthode * de Reel. On pourrait appeler celle de Entier grâce à une redéfinition.

Pour réaliser alors la redéfinition, deux solutions existent :

le typage du premier ordre associé à l'#039;attachement dynamique (c'#039;est le cas de C++, Java, C#…). Cette solution induit une faiblesse dans le typage et peut conduire à des erreurs. Les relations entre type sont définies par le sous-typage (théorie de Liskov) ;
le typage du second ordre (duquel découlent naturellement le polymorphisme et l'#039;appel de la bonne méthode en fonction du type exact de l'#039;objet). Ceci est possible avec Smalltalk et Eiffel. Les relations entre types sont définies par la sous-classification (théorie F-Bound de Cook).

La structure interne des objets et les messages auxquels ils répondent sont définis par des modules logiciels. Ces mêmes modules créent les objets via des opérations dédiées. Deux représentations existent de ces modules : la classe et le prototype.

La classe est une structure informatique particulière dans le langage objet. Elle décrit la structure interne des données et elle définit les méthodes qui s'#039;appliqueront aux objets de même famille (même classe) ou type. Elle propose des méthodes de création des objets dont la représentation sera donc celle donnée par la classe génératrice. Les objets sont dits alors instances de la classe. C'#039;est pourquoi les attributs d'#039;un objet sont aussi appelés variables d'#039;instance et les messages opérations d'#039;instance ou encore méthodes d'#039;instance. L'#039;interface de la classe (l'#039;ensemble des opérations visibles) forme les types des objets. Selon le langage de programmation, une classe est soit considérée comme une structure particulière du langage, soit elle-même comme un objet (objet non-terminal). Dans le premier cas, la classe est définie dans le runtime ; dans l'#039;autre, la classe a besoin elle aussi d'#039;être créée et définie par une classe : ce sont les méta-classes. L'#039;introspection des objets (ou « méta-programmation ») est définie dans ces méta-classes.

La classe peut être décrite par des attributs et des messages. Ces derniers sont alors appelés, par opposition aux attributs et messages d'#039;un objet, variables de classe et opérations de classe ou méthodes de classe. Parmi les langages à classes on retrouve Smalltalk, C++, C#, Java, etc.

Le prototype est un objet à part entière qui sert de prototype de définition de la structure interne et des messages. Les autres objets de mêmes types sont créés par clonage. Dans le prototype, il n'#039;y a plus de distinction entre attributs et messages : ce sont tous des slots. Un slot est un label de l'#039;objet, privé ou public, auquel est attachée une définition (ce peut être une valeur ou une opération). Cet attachement peut être modifié à l'#039;exécution. Chaque ajout d'#039;un slot influence l'#039;objet et l'#039;ensemble de ses clones. Chaque modification d'#039;un slot est locale à l'#039;objet concerné et n'#039;affecte pas ses clones.

Le concept de trait permet de modifier un slot sur un ensemble de clones. Un trait est un ensemble d'#039;opérations de même catégorie (clonage, persistance, etc.) transverse aux objets. Il peut être représenté soit comme une structure particulière du langage, comme un slot dédié ou encore comme un prototype. L'#039;association d'#039;un objet à un trait fait que l'#039;objet et ses clones sont capables de répondre à toutes les opérations du trait. Un objet est toujours associé à au moins un trait, et les traits sont les parents des objets (selon une relation d'#039;héritage). Un trait est donc un mixin doté d'#039;une parenté. Parmi les langages à prototype on trouve Javascript, Self, Io, Slater, Lisaac, etc.

Différents langages utilisent la programmation orientée objet, par exemple PHP, Python, etc.

En PHP la programmation orientée objet est souvent utilisée pour mettre en place une architecture MVC (Modèle Vue Contrôleur), où les modèles représentent des objets.

La modélisation objet consiste à créer un modèle du système informatique à réaliser. Ce modèle représente aussi bien des objets du monde réel que des concepts abstraits propres au métier ou au domaine dans lequel le système sera utilisé.

La modélisation objet commence par la qualification de ces objets sous forme de types ou de classes sous l'#039;angle de la compréhension des besoins et indépendamment de la manière dont ces classes seront mises en œuvre. C'#039;est ce que l'#039;on appelle l'#039;analyse orientée objet ou OOA (acronyme de « Object-Oriented Analysis »). Ces éléments sont alors enrichis et adaptés pour représenter les éléments de la solution technique nécessaires à la réalisation du système informatique. C'#039;est ce que l'#039;on appelle la conception orientée objet ou OOD (acronyme de « Object-Oriented Design »). À un modèle d'#039;analyse peuvent correspondre plusieurs modèles de conception. L'#039;analyse et la conception étant fortement interdépendants, on parle également d'#039;analyse et de conception orientée objet (OOAD). Une fois un modèle de conception établi, il est possible aux développeurs de lui donner corps dans un langage de programmation. C'#039;est ce que l'#039;on appelle la programmation orientée objet ou OOP (en anglais « Object-Oriented Programming »).

Pour écrire ces différents modèles, plusieurs langages et méthodes ont été mis au point. Ces langages sont pour la plupart graphiques. Les trois principaux à s'#039;imposer sont OMT de James Rumbaugh, la méthode Booch de Grady Booch et OOSE de Ivar Jacobson. Toutefois, ces méthodes ont des sémantiques différentes et ont chacune des particularités qui les rendent particulièrement aptes à certains types de problèmes.

OMT offre ainsi une modélisation de la structure de classes très élaborée. Booch a des facilités pour la représentation des interactions entre les objects. OOSE innove avec les cas d'#039;utilisation pour représenter le système dans son environnement. La méthode OMT prévaut sur l'#039;ensemble des autres méthodes au cours de la première partie de la décennie 1990.

À partir de 1994, Booch et Jacobson, rapidement rejoints par Rumbaugh, décident d'#039;unifier leurs approches au sein d'#039;une nouvelle méthode qui soit suffisamment générique pour pouvoir s'#039;appliquer à la plupart des contextes applicatifs. Ils commencent par définir le langage de modélisation UML (Unified Modeling Language) appelé à devenir un standard de l'#039;industrie. Le processus de normalisation est confié à l'#039;Object Management Group (OMG), un organisme destiné à standardiser des technologies orientées objet comme CORBA (acronyme de « Common Object Request Broker Architecture »), un intergiciel (« middleware » en anglais) objet réparti.

Rumbaugh, Booch et Jacobson s'#039;affairent également à mettre au point une méthode permettant d'#039;une manière systématique et répétable d'#039;analyser les exigences et de concevoir et mettre en œuvre une solution logicielle à l'#039;aide de modèles UML. Cette méthode générique de développement orienté objet devient le processus unifié (également connu sous l'#039;appellation anglo-saxonne de « Unified Software Development Process »). Elle est itérative et incrémentale, centrée sur l'#039;architecture et guidée par les cas d'#039;utilisation et la réduction des risques. Le processus unifié est de plus adaptable par les équipes de développement pour prendre en compte au mieux les particularités du contexte.

Néanmoins pour un certain nombre de concepteurs objet, dont Bertrand Meyer, l'#039;inventeur du langage orienté objet Eiffel, guider une modélisation objet par des cas d'#039;utilisations est une erreur de méthode qui n'#039;a rien d'#039;objet et qui est plus proche d'#039;une méthode fonctionnelle. Pour eux, les cas d'#039;utilisations sont relégués à des utilisations plutôt annexes comme la validation d'#039;un modèle par exemple.