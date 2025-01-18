db.articles.insertMany([
  {
    _id: new ObjectId(),
    titre: "lorem ipsum dolor sit amet",
    contenu:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
    auteur: "LOREM IPSIUM",
    date_creation: new Date(),
    tags: ["morel", "muispui", "rolod", "tis", "tema"],
  },
  {
    _id: new ObjectId(),
    titre: "site incroyable",
    contenu:
      "Les prix ne sont vraiment pas chers, et ce n'est absolument pas du scam.",
    auteur: "Place HOLDER",
    date_creation: new Date(),
    tags: ["NoSQL", "NoScam"],
  },
  {
    _id: new ObjectId(),
    titre: "Pourquoi nos NFTs de chats valent 1 million d'euros",
    contenu:
      "Vous pensez qu'un NFT de chat un million d'euros ? Et pourtant...! Ces œuvres révolutionnent literalement l'art et l'économie (surtout la nôtre). Claquez sans plus attendre toutes vos thunes contre un chat qui n'existe pas mais qui ne vieillira pas : c'est le futur.",
    auteur: "j'aurai pu",
    date_creation: new Date(),
    tags: ["donner", "argent", "avenir"],
  },
  {
    _id: new ObjectId(),
    titre: "Comment un NFT de chat a changé ma vie",
    contenu:
      "Apprenez comment acquérir vos premiers NFTs de chats Shiny et impressionnez vos amis lors de dîners mondains. C'est vachement mieux que les cartes Mokepon.",
    auteur: "récuperer le nom",
    date_creation: new Date(),
    tags: ["NoScam", "Témoignage", "Succès"],
  },
  {
    _id: new ObjectId(),
    titre: "Guide pour débutants : acheter un NFT de chat",
    contenu:
      "Acheter un NFT de chat peut sembler intimidant, mais c'est en réalité très simple. Voici les étapes : 1. Prenez votre carte bancaire. 2. Vidangez votre compte en banque. 3. Choisissez un chat qui ressemble à votre âme (indice : il a sûrement un chapeau). 4. Cliquez sur 'Acheter'. Félicitations, vous êtes maintenant l'heureux propriétaire d'un JPEG certifié ! Vos amis vous envieront... ou vous bloqueront.",
    auteur: "du user connecté qui",
    date_creation: new Date(),
    tags: ["Tutoriel", "NFT", "Chat"],
  },
  {
    _id: new ObjectId(),
    titre: "La vérité vraie ",
    contenu:
      "Quand j'ai aucune inspiration, je me sert de mes chats comme placeholder. Et puis, comme j'ai eu aucune inspi' jusqu'à la fin, bah je me suis dis que ce serai du ecommerce de chats. Mais vendre des chats sur internet je trouve ça plutôt bizarre, alors j'ai décidé que ce serait des NFTs parce que pourquoi pas. Puis ensuite je me suis demandé a quoi pouvait ressembler une livraison de NFTs de chats, et je me suis dit que ça devait être un peu comme un chat qui se téléporte. Puis finalement je me suis dis que la coherence c'est un peu surfait et que je voulais juste m'amuser. Et puis en vrai c'est pas plus mal comme sujet les NFTs de chats, c'est un peu comme les chats eux-mêmes : ça ne sert à rien, mais ça attire l'attention.",
    auteur: "a écrit l'article",
    date_creation: new Date(),
    tags: ["Mais", "j'avais", "beaucoup", "trop", "la", "flemme"],
  },
]);
