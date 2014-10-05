CREATE TABLE IF NOT EXISTS `PREFIX_mymod_carrier_cart` (
  `id_mymod_carrier_cart` int(11) NOT NULL AUTO_INCREMENT,
  `id_cart` int(11) NOT NULL,
  `relay_point` text NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_mymod_carrier_cart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;