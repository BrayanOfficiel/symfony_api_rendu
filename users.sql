--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`) VALUES
(1, 'admin@vet.fr', '[\"ROLE_DIRECTOR\"]', '$2y$13$89ltkIkr8c0ZkC/cgqpt0.xTL5EvYm93eP1bvDy10/2/XJAfv6r6C', 'Padmin', 'Nadmin'),
(2, 'veterinaire@vet.fr', '[\"ROLE_VETERINARIAN\"]', '$2y$13$HdpoQvUnBagxCSJWlZzvxeVAosbtLc0y4aIgNSdxd.e7QFAqXqEle', 'Pveterinaire', 'Nveterinaire'),
(3, 'assistant@vet.fr', '[\"ROLE_ASSISTANT\"]', '$2y$13$togVDq3Q2j9rfF.9xHIGI.nQJvfuX7pF5Wcaf.7Fx8Xf0AFVcFneu', 'Passistant', 'Nassistant'),
(4, 'user@gmail.com', '[\"ROLE_USER\"]', '$2y$13$m7dPEY5OwGSCnBFqFDVQPu.95CoPKV5bBcsCzUfuUuZ7lJ37lN6NO', 'Puser', 'Nuser');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
