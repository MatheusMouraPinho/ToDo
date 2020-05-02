-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Maio-2020 às 23:43
-- Versão do servidor: 10.4.8-MariaDB
-- versão do PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `repositorio_de_ideias`
--
CREATE DATABASE IF NOT EXISTS `repositorio_de_ideias` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `repositorio_de_ideias`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area_estudo`
--

CREATE TABLE `area_estudo` (
  `id_area` int(10) NOT NULL,
  `nome_area` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `area_estudo`
--

INSERT INTO `area_estudo` (`id_area`, `nome_area`) VALUES
(1, 'Administração'),
(2, 'Análise e Desenvolvimento de Sistemas'),
(3, 'Arquitetura e Urbanismo'),
(4, 'Artes Visuais'),
(5, 'Biomedicina'),
(6, 'Ciência da Computação'),
(7, 'Ciências Biológicas - Bacharelado'),
(8, 'Ciências Biológicas - Licenciatura'),
(9, 'Ciências Contábeis'),
(10, 'Ciências Econômicas'),
(11, 'Comércio Exterior'),
(12, 'Design de Interiores'),
(13, 'Design Gráfico'),
(14, 'Direito'),
(15, 'Educação Física - Bacharelado'),
(16, 'Educação Física - Licenciatura'),
(17, 'Enfermagem'),
(18, 'Engenharia Civil'),
(19, 'Engenharia de Produção'),
(20, 'Engenharia Elétrica'),
(21, 'Engenharia Mecânica'),
(22, 'Estética e Cosmética'),
(23, 'Farmácia'),
(24, 'Fisioterapia'),
(25, 'Fotografia'),
(26, 'Gastronomia'),
(27, 'Geografia Gestão Comercial'),
(28, 'Gestão de Recursos Humanos - Tecnólogo'),
(29, 'Gestão Financeira'),
(30, 'História Jogos Digitais'),
(31, 'Jornalismo'),
(32, 'Letras (Português/Inglês)'),
(33, 'Letras (Português/Japonês)'),
(34, 'Logística'),
(35, 'Marketing'),
(36, 'Matemática'),
(37, 'Medicina Veterinária'),
(38, 'Música'),
(39, 'Nutrição'),
(40, 'Odontologia'),
(41, 'Pedagogia'),
(42, 'Processos Gerenciais'),
(43, 'Psicologia'),
(44, 'Publicidade e Propaganda'),
(45, 'Química'),
(46, 'Rádio, TV e Internet'),
(47, 'Redes de Computadores'),
(48, 'Relações Internacionais'),
(49, 'Relações Públicas'),
(50, 'Segurança no Trabalho'),
(51, 'Serviço Social'),
(52, 'Sistemas de Informação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao_postagem`
--

CREATE TABLE `avaliacao_postagem` (
  `id_avaliacao` int(10) NOT NULL,
  `id_postagem` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `inovacao_avaliacao` double NOT NULL,
  `complexidade_avaliacao` double NOT NULL,
  `potencial_avaliacao` double NOT NULL,
  `comentario_avaliacao` varchar(255) DEFAULT NULL,
  `media_avaliacao` double NOT NULL,
  `id_avaliador` int(11) DEFAULT NULL,
  `data_avaliacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria_postagem`
--

CREATE TABLE `categoria_postagem` (
  `id_categoria` int(10) NOT NULL,
  `categoria_postagem` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categoria_postagem`
--

INSERT INTO `categoria_postagem` (`id_categoria`, `categoria_postagem`) VALUES
(1, 'Ideia'),
(2, 'Sugestão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentarios` int(10) NOT NULL,
  `id_usuarios` int(10) NOT NULL,
  `id_postagem` int(10) NOT NULL,
  `conteudo_comentarios` varchar(255) NOT NULL,
  `data_comentarios` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `img_postagem`
--

CREATE TABLE `img_postagem` (
  `id_img` int(10) NOT NULL,
  `id_postagem` int(10) NOT NULL,
  `img_post` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao_ensino`
--

CREATE TABLE `instituicao_ensino` (
  `id_instituicao` int(10) NOT NULL,
  `nome_instituicao` varchar(100) NOT NULL,
  `sigla_instituicao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `instituicao_ensino`
--

INSERT INTO `instituicao_ensino` (`id_instituicao`, `nome_instituicao`, `sigla_instituicao`) VALUES
(1, 'Universidade Cruzeiro do Sul', 'Cruzeiro do Sul'),
(2, 'Universidade Positivo', 'POSITIVO'),
(3, 'Centro Universitário Braz Cubas', 'Braz Cubas'),
(4, 'Centro Universitário de João Pessoa', 'UNIPÊ'),
(5, 'Centro Universitário da Serra Gaúcha', 'FSG'),
(6, 'Faculdade Inedi ', 'CESUCA'),
(7, 'Centro Universitário N. Sra. do Patrocínio', 'CEUNSP'),
(8, 'Faculdade São Sebastião', 'FASS'),
(9, 'Centro Universitário do Distrito Federal ', 'UDF'),
(10, 'Centro Universitário Módulo', 'Módulo'),
(11, 'Universidade de Franca', 'UNIFRAN'),
(12, 'Universidade Cidade de São Paulo', 'UNICID');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2020_04_13_215849_create_verificas_table', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_acesso`
--

CREATE TABLE `nivel_acesso` (
  `id_nivel` int(10) NOT NULL,
  `nivel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`id_nivel`, `nivel`) VALUES
(1, 'Usuário '),
(2, 'Avaliador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `postagens`
--

CREATE TABLE `postagens` (
  `id_postagem` int(10) NOT NULL,
  `id_usuarios` int(10) NOT NULL,
  `id_situacao_postagem` int(10) NOT NULL DEFAULT 2,
  `id_categoria` int(10) NOT NULL,
  `titulo_postagem` varchar(50) NOT NULL,
  `descricao_postagem` varchar(255) NOT NULL,
  `likes_postagem` int(10) NOT NULL DEFAULT 0,
  `data_postagem` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regiao_cidade`
--

CREATE TABLE `regiao_cidade` (
  `id_regiao_cidade` int(10) NOT NULL,
  `id_estado` int(10) NOT NULL,
  `nome_cidade` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `regiao_cidade`
--

INSERT INTO `regiao_cidade` (`id_regiao_cidade`, `id_estado`, `nome_cidade`) VALUES
(1, 1, 'Brasiléia'),
(2, 1, 'Imperatriz'),
(3, 1, 'Rio Branco'),
(4, 1, 'Rodrigues Alves'),
(5, 1, 'Sena Madureira'),
(6, 1, 'Tarauacá'),
(7, 2, 'Arapiraca'),
(8, 2, 'Atalaia'),
(9, 2, 'Boca da Mata'),
(10, 2, 'Coruripe'),
(11, 2, 'Delmiro Gouveia'),
(12, 2, 'Maceió'),
(13, 2, 'Palmeira dos Índios'),
(14, 2, 'Penedo'),
(15, 2, 'Rio largo'),
(16, 2, 'Santana do Ipanema'),
(17, 2, 'Santana do Mundaú'),
(18, 2, 'São Miguel dos Campos'),
(19, 2, 'Teotônio Vilela'),
(20, 2, 'União dos Palmares'),
(21, 2, 'Viçosa'),
(22, 3, 'Macapá'),
(23, 3, 'Oiapoque'),
(24, 4, 'Boca do Acre'),
(25, 4, 'Fonte Boa'),
(26, 4, 'Itacoatiara'),
(27, 4, 'Manaus'),
(28, 4, 'Novo Aripuanã'),
(38, 5, 'Capim Grosso'),
(43, 5, 'Vitória da Conquista'),
(44, 5, 'Salvador'),
(45, 5, 'Feira de Santana'),
(46, 5, 'Camaçari'),
(47, 5, 'Juazeiro'),
(48, 5, 'Itabuna'),
(49, 5, 'Lauro de Freitas'),
(50, 5, 'Ilhéus'),
(51, 5, 'Jequié'),
(52, 5, 'Teixeira de Freitas'),
(53, 5, 'Barreiras'),
(54, 5, 'Alagoinhas'),
(55, 5, 'Porto Seguro'),
(56, 5, 'Simões Filho'),
(57, 5, 'Paulo Afonso'),
(58, 5, 'Eunápolis'),
(59, 5, 'Santo Antônio de Jesus'),
(60, 5, 'Valença'),
(61, 5, 'Candeias'),
(62, 5, 'Guanambi'),
(63, 5, 'Jacobina'),
(64, 5, 'Luís Eduardo Magalhães'),
(65, 5, 'Serrinha'),
(66, 5, 'Senhor do Bonfim'),
(67, 5, 'Dias d\'Ávila'),
(68, 5, 'Itapetinga'),
(69, 5, 'Irecê'),
(70, 5, 'Campo Formoso'),
(71, 5, 'Casa Nova'),
(72, 5, 'Bom Jesus da Lapa'),
(73, 5, 'Brumado'),
(74, 5, 'Conceição do Coité'),
(75, 5, 'Itamaraju'),
(76, 5, 'Itaberaba'),
(77, 5, 'Cruz das Almas'),
(78, 5, 'Ipirá'),
(79, 5, 'Santo Amaro'),
(80, 5, 'Euclides da Cunha'),
(81, 5, 'Catu'),
(82, 5, 'Jaguaquara'),
(83, 5, 'Araci'),
(84, 5, 'Ribeira do Pombal'),
(85, 5, 'Barra'),
(86, 5, 'Santo Estêvão'),
(87, 5, 'Caetité'),
(88, 5, 'Tucano'),
(89, 5, 'Monte Santo'),
(90, 5, 'Macaúbas'),
(91, 5, 'Poções'),
(92, 5, 'Xique-Xique'),
(93, 5, 'Ipiaú'),
(94, 5, 'Mata de São João'),
(95, 5, 'Livramento de Nossa Senhora'),
(96, 5, 'Maragogipe'),
(97, 5, 'São Sebastião do Passé'),
(98, 5, 'Seabra'),
(99, 5, 'Nova Viçosa'),
(100, 5, 'Vera Cruz'),
(101, 5, 'Entre Rios'),
(102, 5, 'Remanso'),
(103, 6, 'São Gonçalo do Amarante'),
(104, 6, 'Fortaleza'),
(105, 6, 'Caucaia'),
(106, 6, 'Juazeiro do Norte'),
(107, 6, 'Maracanaú'),
(108, 6, 'Sobral'),
(109, 6, 'Crato'),
(110, 6, 'Itapipoca'),
(111, 6, 'Maranguape'),
(112, 6, 'Iguatu'),
(113, 6, 'Quixadá'),
(114, 6, 'Pacatuba'),
(115, 6, 'Quixeramobim'),
(116, 6, 'Aquiraz'),
(117, 6, 'Russas'),
(118, 6, 'Canindé'),
(119, 6, 'Tianguá'),
(120, 6, 'Crateús'),
(121, 6, 'Aracati'),
(122, 6, 'Pacajus'),
(123, 6, 'Cascavel'),
(124, 6, 'Icó'),
(125, 6, 'Horizonte'),
(126, 6, 'Camocim'),
(127, 6, 'Acaraú'),
(128, 6, 'Morada Nova'),
(129, 6, 'Viçosa do Ceará'),
(130, 6, 'Barbalha'),
(131, 6, 'Limoeiro do Norte'),
(132, 6, 'Tauá'),
(133, 6, 'Trairi'),
(134, 6, 'Granja'),
(135, 6, 'Boa Viagem'),
(136, 6, 'Acopiara'),
(137, 6, 'Eusébio'),
(138, 6, 'Beberibe'),
(139, 6, 'Itapajé'),
(140, 6, 'Brejo Santo'),
(141, 6, 'Mauriti'),
(142, 6, 'São Benedito'),
(143, 6, 'Mombaça'),
(144, 6, 'Santa Quitéria'),
(145, 6, 'Amontada'),
(146, 6, 'Pedra Branca'),
(147, 6, 'Ipu'),
(148, 6, 'Itarema'),
(149, 6, 'Várzea Alegre'),
(150, 7, 'Brasília'),
(151, 7, 'Ceilândia'),
(152, 8, 'Alegre'),
(153, 8, 'Aracruz'),
(154, 8, 'Baixo Guandu'),
(155, 8, 'Cachoeiro de Itapemirim'),
(156, 8, 'Cariacica'),
(157, 8, 'Castelo'),
(158, 8, 'Ecoporanga'),
(159, 8, 'Guarapari'),
(160, 8, 'Iconha'),
(161, 8, 'Linhares'),
(162, 8, 'Marataízes'),
(163, 8, 'Nova Venécia'),
(164, 8, 'Pinheiros'),
(165, 8, 'São Mateus'),
(166, 8, 'Serra'),
(167, 8, 'Viana'),
(168, 8, 'Vila Velha'),
(169, 8, 'Vitória'),
(170, 9, 'Abadiânia'),
(171, 9, 'Águas Lindas de Goiás'),
(172, 9, 'Alexânia'),
(173, 9, 'Anápolis'),
(174, 9, 'Aparecida de Goiânia'),
(175, 9, 'Bela Vista de Goiás'),
(176, 9, 'Caldas Novas'),
(177, 9, 'Catalão'),
(178, 9, 'Ceres'),
(179, 9, 'Cidade Ocidental'),
(180, 9, 'Edéia'),
(181, 9, 'Formosa'),
(182, 9, 'Goiânia'),
(183, 9, 'Itaberaí'),
(184, 9, 'Jataí'),
(185, 9, 'Luziânia'),
(186, 9, 'Novo Gama'),
(187, 9, 'Porangatu'),
(188, 9, 'Quirinopolis'),
(189, 9, 'Rio Verde'),
(190, 9, 'Rubiataba'),
(191, 9, 'Senador Canedo'),
(192, 9, 'Silvânia'),
(193, 9, 'Trindade'),
(194, 9, 'Uruaçu'),
(195, 9, 'Valparaiso de Goiás'),
(196, 9, 'Vianópolis'),
(197, 27, 'Araguatins'),
(198, 27, 'Gurupi'),
(199, 27, 'Palmas'),
(200, 26, 'Aracaju'),
(201, 26, 'Barra dos Coqueiros'),
(202, 26, 'Estância'),
(203, 26, 'Indiaroba'),
(204, 26, 'Itabaiana'),
(205, 26, 'Lagarto'),
(206, 26, 'Porto da Folha'),
(207, 26, 'Tobias Barreto'),
(208, 23, 'Boa Vista '),
(209, 23, 'Rorainópolis'),
(210, 20, 'Baraúna'),
(211, 20, 'Caicó'),
(212, 20, 'Extremoz'),
(213, 20, 'Goianinha'),
(214, 20, 'Macaíba'),
(215, 20, 'Macau'),
(216, 20, 'Mossoró'),
(217, 20, 'Natal'),
(218, 20, 'Parnamirim'),
(219, 20, 'Santa Cruz'),
(220, 20, 'São Paulo do Potengi '),
(221, 12, 'Amambaí'),
(222, 12, 'Campo Grande'),
(223, 12, 'Corumbá'),
(224, 12, 'Costa Rica'),
(225, 12, 'Coxim'),
(226, 12, 'Dourados'),
(227, 12, 'Jardim'),
(228, 12, 'Mundo Novo'),
(229, 12, 'Naviraí'),
(230, 12, 'Nova Andradina'),
(231, 12, 'Ponta Porã'),
(232, 12, 'Três Lagoas'),
(233, 18, 'Baixa Grande do Ribeiro '),
(234, 18, 'Campo Maior'),
(235, 18, 'Canto do Buriti'),
(236, 18, 'Guadalupe'),
(237, 18, 'Pedro II'),
(238, 18, 'Piripiri'),
(239, 18, 'São Raimundo Nonato'),
(240, 18, 'Teresina'),
(241, 18, 'Uruçuí'),
(242, 11, 'Alto Taquari'),
(243, 11, 'Aripuanã'),
(244, 11, 'Barra dos Garças'),
(245, 11, 'Brasnorte'),
(246, 11, 'Confresa'),
(247, 11, 'Cuiabá'),
(248, 11, 'Lucas do Rio Verde'),
(249, 11, 'Nova Mutum'),
(250, 11, 'Nova Ubiratã'),
(251, 11, 'Paranatinga'),
(252, 11, 'Primavera do Leste'),
(253, 11, 'Querência'),
(254, 11, 'Rondonópolis'),
(255, 11, 'Sinop'),
(256, 11, 'Sorriso'),
(257, 11, 'Tangará da Serra'),
(258, 11, 'Várzea Grande'),
(259, 22, 'Alto Alegre dos Parecis'),
(260, 22, 'Alto Paraíso'),
(261, 22, 'Ariquemes'),
(262, 22, 'Buritis'),
(263, 22, 'Cacoal'),
(264, 22, 'Cerejeiras'),
(265, 22, 'Cujubim'),
(266, 22, 'Espigão do Oeste'),
(267, 22, 'Guajará-Mirim'),
(268, 22, 'Jaru'),
(269, 22, 'Ji-Paraná'),
(270, 22, 'Machadinho D\'Oeste'),
(271, 22, 'Mirante da Serra'),
(272, 22, 'Monte Negro'),
(273, 22, 'Ouro Preto do Oeste'),
(274, 22, 'Porto Velho'),
(275, 22, 'Rolim de Moura'),
(276, 22, 'Vilhena'),
(277, 13, 'Betim'),
(278, 13, 'Montes Claros'),
(279, 13, 'Ribeirão das Neves'),
(280, 13, 'Uberaba'),
(281, 13, 'Ipatinga'),
(282, 13, 'Sete Lagoas'),
(283, 13, 'Divinópolis	'),
(284, 13, 'Governador Valadares'),
(285, 13, 'Belo Horizonte	'),
(286, 13, 'Uberlândi'),
(287, 13, 'Contagem'),
(288, 13, 'Juiz de Fora'),
(289, 13, 'Santa Luzia'),
(290, 13, 'Ibirité'),
(291, 13, 'Poços de Caldas'),
(292, 13, 'Patos de Minas'),
(293, 13, 'Pouso Alegre'),
(294, 13, 'Teófilo Otoni'),
(295, 13, 'Barbacena'),
(296, 13, 'Sabará'),
(297, 13, 'Varginha'),
(298, 13, 'Vespasiano'),
(299, 13, 'Itabira'),
(300, 13, 'Araguari'),
(301, 13, 'Passos'),
(302, 13, 'Ubá'),
(303, 13, 'Coronel Fabriciano'),
(304, 13, 'Muriaé'),
(305, 13, 'Ituiutaba'),
(306, 13, 'Araxá'),
(307, 13, 'Lavras'),
(308, 13, 'Itajubá'),
(309, 13, 'Nova Serrana'),
(310, 13, 'Itaúna'),
(311, 13, 'Pará de Minas'),
(312, 13, 'Paracatu'),
(313, 13, 'Caratinga'),
(314, 13, 'Nova Lima'),
(315, 13, 'São João del Rei'),
(316, 13, 'Timóteo'),
(317, 13, 'Manhuaçu'),
(318, 13, 'Patrocínio'),
(319, 13, 'Unaí'),
(320, 13, 'Curvelo'),
(321, 13, 'Alfenas'),
(322, 13, 'João Monlevade	'),
(323, 13, 'Três Corações'),
(324, 13, 'Viçosa'),
(325, 13, 'Cataguases'),
(326, 13, 'Conselheiro Lafaiete'),
(327, 25, 'São Paulo'),
(328, 25, 'Guarulhos'),
(329, 25, 'Campinas'),
(330, 25, 'São José dos Campos'),
(331, 25, 'Santo André'),
(332, 25, 'Ribeirão Preto'),
(333, 25, 'Osasco'),
(334, 25, 'Sorocaba'),
(335, 25, 'Mauá'),
(336, 25, 'São José do Rio Preto'),
(337, 25, 'Mogi das Cruzes'),
(338, 25, 'Santos'),
(339, 25, 'Diadema'),
(340, 25, 'Jundiaí'),
(341, 25, 'Piracicaba'),
(342, 25, 'Carapicuíba'),
(343, 25, 'Bauru'),
(344, 25, 'Itaquaquecetuba'),
(345, 25, 'São Vicente'),
(346, 25, 'Franca'),
(347, 25, 'Praia Grande'),
(348, 25, 'Guarujá'),
(349, 25, 'Taubaté'),
(350, 25, 'Limeira'),
(351, 25, 'Suzano'),
(352, 25, 'Taboão da Serra'),
(353, 25, 'Sumaré'),
(354, 25, 'Barueri'),
(355, 25, 'Embu das Artes'),
(356, 25, 'São Carlos'),
(357, 25, 'Indaiatuba'),
(358, 25, 'Cotia'),
(359, 25, 'Americana'),
(360, 25, 'Marília'),
(361, 25, 'Itapevi'),
(362, 25, 'Araraquara'),
(363, 25, 'Jacareí'),
(364, 25, 'Hortolândia'),
(365, 25, 'Presidente Prudente'),
(366, 25, 'Rio Claro'),
(367, 25, 'Araçatuba'),
(368, 25, 'Ferraz de Vasconcelos'),
(369, 25, 'Santa Bárbara d\'Oeste'),
(370, 25, 'Francisco Morato'),
(371, 25, 'Itapecerica da Serra'),
(372, 25, 'Itu'),
(373, 25, 'Bragança Paulista'),
(374, 25, 'Pindamonhangaba'),
(375, 25, 'Itapetininga'),
(376, 25, 'São Caetano do Sul'),
(377, 25, 'Franco da Rocha'),
(378, 25, 'Mogi Guaçu'),
(379, 25, 'Jaú'),
(380, 25, 'Botucatu'),
(381, 25, 'Atibaia'),
(382, 25, 'Santana de Parnaíba'),
(383, 25, 'Araras'),
(384, 25, 'Cubatão'),
(385, 25, 'Valinhos'),
(386, 25, 'Sertãozinho'),
(387, 25, 'Jandira'),
(388, 25, 'Birigui'),
(389, 25, 'Ribeirão Pires'),
(390, 25, 'Votorantim'),
(391, 25, 'Barretos'),
(392, 25, 'Catanduva'),
(393, 25, 'Várzea Paulista'),
(394, 25, 'Guaratinguetá'),
(395, 25, 'Tatuí'),
(396, 25, 'Caraguatatuba'),
(397, 25, 'Ubatuba'),
(398, 25, 'São Sebastião'),
(399, 25, 'São Bernardo do Campo'),
(400, 19, 'Rio de Janeiro'),
(401, 19, 'São Gonçalo'),
(402, 19, 'Duque de Caxias'),
(403, 19, 'Nova Iguaçu'),
(404, 19, 'Niterói'),
(405, 19, 'Belford Roxo'),
(406, 19, 'São João de Meriti'),
(407, 19, 'Petrópolis'),
(408, 19, 'Volta Redonda'),
(409, 19, 'Macaé'),
(410, 19, 'Magé'),
(411, 19, 'Itaboraí'),
(412, 19, 'Cabo Frio'),
(413, 19, 'Angra dos Reis'),
(414, 19, 'Nova Friburgo'),
(415, 19, 'Barra Mansa'),
(416, 19, 'Teresópolis'),
(417, 19, 'Mesquita'),
(418, 19, 'Nilópolis'),
(419, 19, 'Maricá'),
(420, 19, 'Rio das Ostras'),
(421, 19, 'Queimados'),
(422, 19, 'Itaguaí'),
(423, 19, 'Araruama'),
(424, 19, 'Resende'),
(425, 19, 'Japeri'),
(426, 19, 'São Pedro da Aldeia'),
(427, 19, 'Itaperuna'),
(428, 19, 'Barra do Piraí'),
(429, 19, 'Campos dos Goytacazes'),
(430, 14, 'Belém'),
(431, 14, 'Ananindeua'),
(432, 14, 'Santarém'),
(433, 14, 'Marabá'),
(434, 14, 'Parauapebas'),
(435, 14, 'Castanhal'),
(436, 14, 'Abaetetuba'),
(437, 14, 'Cametá'),
(438, 14, 'Marituba'),
(439, 14, 'Bragança'),
(440, 14, 'São Félix do Xingu'),
(441, 14, 'Barcarena'),
(442, 14, 'Altamira'),
(443, 14, 'Tucuruí'),
(444, 14, 'Paragominas'),
(445, 14, 'Tailândia'),
(446, 14, 'Breves'),
(447, 14, 'Itaituba'),
(448, 14, 'Redenção'),
(449, 14, 'Moju'),
(450, 14, 'Novo Repartimento'),
(451, 14, 'Oriximiná'),
(452, 14, 'Santana do Araguaia'),
(453, 14, 'Santa Izabel do Pará'),
(454, 14, 'Capanema'),
(455, 24, 'ARARANGUÁ'),
(456, 24, 'BALNEÁRIO CAMBORIÚ'),
(457, 24, 'BIGUAÇU'),
(458, 24, 'BLUMENAU'),
(459, 24, 'BRUSQUE'),
(460, 24, 'CAÇADOR'),
(461, 24, 'CAMBORIÚ'),
(462, 24, 'CANOINHAS'),
(463, 24, 'CHAPECÓ'),
(464, 24, 'CONCÓRDIA'),
(465, 24, 'CRICIÚMA'),
(466, 24, 'FLORIANÓPOLIS'),
(467, 24, 'GASPAR'),
(468, 24, 'IMBITUBA'),
(469, 24, 'ITAJAÍ'),
(470, 24, 'ITAPEMA'),
(471, 24, 'JARAGUÁ DO SUL'),
(472, 24, 'JOINVILLE'),
(473, 24, 'LAGES'),
(474, 24, 'NAVEGANTES'),
(475, 24, 'PALHOÇA'),
(476, 24, 'PENHA'),
(477, 24, 'RIO DO SUL'),
(478, 24, 'SÃO JOSÉ'),
(479, 24, 'SÃO MIGUEL DO OESTE'),
(480, 24, 'TIMBÓ'),
(481, 24, 'TUBARÃO'),
(482, 24, 'VIDEIRA'),
(483, 24, 'XANXERÊ'),
(484, 24, 'SÃO FRANCISCO DO SUL'),
(485, 15, 'Cabedelo'),
(486, 15, 'Cajazeiras'),
(487, 15, 'Campina Grande'),
(488, 15, 'Conceição'),
(489, 15, 'Guarabira'),
(490, 15, 'Itabaiana'),
(491, 15, 'João Pessoa'),
(492, 15, 'Mamanguape'),
(493, 15, 'Monteiro'),
(494, 15, 'Patos'),
(495, 15, 'Pedras de Fogo'),
(496, 15, 'São José de Piranhas'),
(497, 15, 'Sapé'),
(498, 15, 'Sousa'),
(499, 17, 'Afogados da Ingazeira'),
(500, 17, 'Araripina'),
(501, 17, 'Bezerros'),
(502, 17, 'Bom Conselho'),
(503, 17, 'Bonito'),
(504, 17, 'Cabo de Santo Agostinho'),
(505, 17, 'Camaragipe'),
(506, 17, 'Carpina'),
(507, 17, 'Caruaru'),
(508, 17, 'Glória do Goitá'),
(509, 17, 'Goiana'),
(510, 17, 'Gravatá'),
(511, 17, 'Jaboatão dos Guararapes'),
(512, 17, 'Limoeiro'),
(513, 17, 'Olinda'),
(514, 17, 'Ouricuri'),
(515, 17, 'Paulista'),
(516, 17, 'Pesqueira'),
(517, 17, 'Petrolina'),
(518, 17, 'Recife'),
(519, 17, 'Timbaúba'),
(520, 17, 'Trindade'),
(521, 17, 'Triunfo'),
(522, 17, 'Vitória de Santo Antão'),
(523, 21, 'Porto Alegre'),
(524, 21, 'Caxias do Sul'),
(525, 21, 'Canoas'),
(526, 21, 'Pelotas'),
(527, 21, 'Santa Maria'),
(528, 21, 'Gravataí'),
(529, 21, 'Viamão'),
(530, 21, 'Novo Hamburgo'),
(531, 21, 'São Leopoldo'),
(532, 21, 'Rio Grande'),
(533, 21, 'Alvorada'),
(534, 21, 'Passo Fundo'),
(535, 21, 'Sapucaia do Sul'),
(536, 21, 'Santa Cruz do Sul'),
(537, 21, 'Cachoeirinha'),
(538, 21, 'Uruguaiana'),
(539, 21, 'Bagé'),
(540, 21, 'Bento Gonçalves'),
(541, 21, 'Erechim'),
(542, 21, 'Guaíba'),
(543, 21, 'Lajeado'),
(544, 21, 'Ijuí'),
(545, 21, 'Esteio'),
(546, 21, 'Cachoeira do Sul'),
(547, 21, 'Sapiranga'),
(548, 21, 'Santo Ângelo'),
(549, 21, 'Santana do Livramento'),
(550, 21, 'Alegrete'),
(551, 21, 'Santa Rosa'),
(552, 21, 'Farroupilha'),
(553, 21, 'Venâncio Aires'),
(554, 21, 'Campo Bom'),
(555, 21, 'Camaquã'),
(556, 21, 'Vacaria'),
(557, 10, 'São Luís'),
(558, 10, 'Imperatriz'),
(559, 10, 'São José de Ribamar'),
(560, 10, 'Timon'),
(561, 10, 'Caxias'),
(562, 10, 'Codó'),
(563, 10, 'Paço do Lumiar'),
(564, 10, 'Açailândia'),
(565, 10, 'Bacabal'),
(566, 10, 'Balsas'),
(567, 10, 'Santa Inês'),
(568, 10, 'Barra do Corda'),
(569, 10, 'Pinheiro'),
(570, 10, 'Chapadinha'),
(571, 10, 'Santa Luzia'),
(572, 10, 'Buriticupu'),
(573, 10, 'Grajaú'),
(574, 10, 'Itapecuru-Mirim'),
(575, 10, 'Coroatá'),
(576, 10, 'Barreirinhas'),
(577, 10, 'Tutoia'),
(578, 10, 'Vargem Grande'),
(579, 10, 'Viana'),
(580, 10, 'Zé Doca'),
(581, 10, 'Lago da Pedra'),
(582, 10, 'Coelho Neto'),
(583, 10, 'Presidente Dutra'),
(584, 10, 'Araioses'),
(585, 10, 'São Bento'),
(586, 10, 'Rosário'),
(587, 10, 'Santa Helena'),
(588, 10, 'Estreito'),
(589, 10, 'Tuntum'),
(590, 10, 'Bom Jardim');

-- --------------------------------------------------------

--
-- Estrutura da tabela `regiao_estado`
--

CREATE TABLE `regiao_estado` (
  `id_regiao_estado` int(10) NOT NULL,
  `nome_estado` varchar(50) NOT NULL,
  `uf_regiao_estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `regiao_estado`
--

INSERT INTO `regiao_estado` (`id_regiao_estado`, `nome_estado`, `uf_regiao_estado`) VALUES
(1, 'Acre', 'AC'),
(2, 'Alagoas', 'AL'),
(3, 'Amapá', 'AP'),
(4, 'Amazonas', 'AM'),
(5, 'Bahia', 'BA'),
(6, 'Ceará', 'CE'),
(7, 'Distrito Federal', 'DF'),
(8, 'Espírito Santo', 'ES'),
(9, 'Goiás', 'GO'),
(10, 'Maranhão', 'MA'),
(11, 'Mato Grosso', 'MT'),
(12, 'Mato Grosso do Sul', 'MS'),
(13, 'Minas Gerais', 'MG'),
(14, 'Pará', 'PA'),
(15, 'Paraíba', 'PB'),
(16, 'Paraná', 'PR'),
(17, 'Pernambuco', 'PE'),
(18, 'Piauí', 'PI'),
(19, 'Rio de Janeiro', 'RJ'),
(20, 'Rio Grande do Norte', 'RN'),
(21, 'Rio Grande do Sul', 'RS'),
(22, 'Rondônia ', 'RO'),
(23, 'Roraima', 'RR'),
(24, 'Santa Catarina', 'SC'),
(25, 'São Paulo', 'SP'),
(26, 'Sergipe', 'SE'),
(27, 'Tocantins', 'TO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_postagem`
--

CREATE TABLE `situacao_postagem` (
  `id_situacao_postagem` int(10) NOT NULL,
  `situacao_postagem` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `situacao_postagem`
--

INSERT INTO `situacao_postagem` (`id_situacao_postagem`, `situacao_postagem`) VALUES
(1, 'Avaliado'),
(2, 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao_usuario`
--

CREATE TABLE `situacao_usuario` (
  `id_situacao_usuario` int(10) NOT NULL,
  `situacao_usuario` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `situacao_usuario`
--

INSERT INTO `situacao_usuario` (`id_situacao_usuario`, `situacao_usuario`) VALUES
(1, 'Ativo'),
(2, 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `registro` int(11) NOT NULL COMMENT 'Esse campo se refere ao RGM/CPF do usuário',
  `senha` varchar(200) NOT NULL,
  `nivel` int(10) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `id_situacao` int(10) NOT NULL DEFAULT 2,
  `id_area` int(10) DEFAULT NULL,
  `id_instituicao` int(10) DEFAULT NULL,
  `id_regiao_cidade` int(10) DEFAULT NULL,
  `img_usuarios` longblob DEFAULT NULL,
  `telefone_usuario` bigint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `registro`, `senha`, `nivel`, `email_verified_at`, `id_situacao`, `id_area`, `id_instituicao`, `id_regiao_cidade`, `img_usuarios`, `telefone_usuario`) VALUES
(12, 'Matheus Moura', 'Matheusmpinho@Outlook.com', 20867000, '$2y$10$oUSCR9yl9V/s5g3kynVwnezl1U9i8Z8bPDFGJGdBdU9te17eje0xC', 1, '2000-01-27 02:00:00', 2, NULL, NULL, NULL, NULL, NULL),
(17, 'Jonathan Dias', 'jonathangoncalves.dias2001@gmail.com', 22132066, '$2y$10$A2LLlqDL4zVa5RQPghjXkeV999TBdX03.0GG.4ifuJ/ahWSnSyw6K', 1, '2020-04-30 23:23:51', 2, 2, 10, 398, 0x31376a6f6e617468616e2d646961732e6a7065672e6a7065672e6a7065672e6a7065672e6a7065672e6a7065672e6a7065672e6a7065672e706e672e6a7065672e6a7065672e6a7065672e6a7065672e6a706567, 12981489308);

-- --------------------------------------------------------

--
-- Estrutura da tabela `verifica`
--

CREATE TABLE `verifica` (
  `user_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `area_estudo`
--
ALTER TABLE `area_estudo`
  ADD PRIMARY KEY (`id_area`);

--
-- Índices para tabela `avaliacao_postagem`
--
ALTER TABLE `avaliacao_postagem`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `id_postagem` (`id_postagem`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_avaliador` (`id_avaliador`);

--
-- Índices para tabela `categoria_postagem`
--
ALTER TABLE `categoria_postagem`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentarios`),
  ADD KEY `id_usuarios` (`id_usuarios`),
  ADD KEY `id_postagem` (`id_postagem`);

--
-- Índices para tabela `img_postagem`
--
ALTER TABLE `img_postagem`
  ADD PRIMARY KEY (`id_img`),
  ADD KEY `id_postagem` (`id_postagem`);

--
-- Índices para tabela `instituicao_ensino`
--
ALTER TABLE `instituicao_ensino`
  ADD PRIMARY KEY (`id_instituicao`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Índices para tabela `postagens`
--
ALTER TABLE `postagens`
  ADD PRIMARY KEY (`id_postagem`),
  ADD KEY `id_usuarios` (`id_usuarios`),
  ADD KEY `id_situacao` (`id_situacao_postagem`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices para tabela `regiao_cidade`
--
ALTER TABLE `regiao_cidade`
  ADD PRIMARY KEY (`id_regiao_cidade`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Índices para tabela `regiao_estado`
--
ALTER TABLE `regiao_estado`
  ADD PRIMARY KEY (`id_regiao_estado`);

--
-- Índices para tabela `situacao_postagem`
--
ALTER TABLE `situacao_postagem`
  ADD PRIMARY KEY (`id_situacao_postagem`);

--
-- Índices para tabela `situacao_usuario`
--
ALTER TABLE `situacao_usuario`
  ADD PRIMARY KEY (`id_situacao_usuario`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_usuarios` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `registro_usuarios` (`registro`),
  ADD KEY `id_situacao_user` (`id_situacao`),
  ADD KEY `id_nivel` (`nivel`),
  ADD KEY `id_area` (`id_area`),
  ADD KEY `id_instituicao` (`id_instituicao`),
  ADD KEY `id_regiao_cidade` (`id_regiao_cidade`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `area_estudo`
--
ALTER TABLE `area_estudo`
  MODIFY `id_area` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `avaliacao_postagem`
--
ALTER TABLE `avaliacao_postagem`
  MODIFY `id_avaliacao` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria_postagem`
--
ALTER TABLE `categoria_postagem`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentarios` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `img_postagem`
--
ALTER TABLE `img_postagem`
  MODIFY `id_img` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `instituicao_ensino`
--
ALTER TABLE `instituicao_ensino`
  MODIFY `id_instituicao` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  MODIFY `id_nivel` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `postagens`
--
ALTER TABLE `postagens`
  MODIFY `id_postagem` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `regiao_cidade`
--
ALTER TABLE `regiao_cidade`
  MODIFY `id_regiao_cidade` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=591;

--
-- AUTO_INCREMENT de tabela `regiao_estado`
--
ALTER TABLE `regiao_estado`
  MODIFY `id_regiao_estado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de tabela `situacao_postagem`
--
ALTER TABLE `situacao_postagem`
  MODIFY `id_situacao_postagem` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `situacao_usuario`
--
ALTER TABLE `situacao_usuario`
  MODIFY `id_situacao_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliacao_postagem`
--
ALTER TABLE `avaliacao_postagem`
  ADD CONSTRAINT `avaliacao_postagem_ibfk_1` FOREIGN KEY (`id_postagem`) REFERENCES `postagens` (`id_postagem`),
  ADD CONSTRAINT `avaliacao_postagem_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `avaliacao_postagem_ibfk_3` FOREIGN KEY (`id_avaliador`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_postagem`) REFERENCES `postagens` (`id_postagem`);

--
-- Limitadores para a tabela `img_postagem`
--
ALTER TABLE `img_postagem`
  ADD CONSTRAINT `img_postagem_ibfk_1` FOREIGN KEY (`id_postagem`) REFERENCES `postagens` (`id_postagem`);

--
-- Limitadores para a tabela `postagens`
--
ALTER TABLE `postagens`
  ADD CONSTRAINT `postagens_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `postagens_ibfk_2` FOREIGN KEY (`id_situacao_postagem`) REFERENCES `situacao_postagem` (`id_situacao_postagem`),
  ADD CONSTRAINT `postagens_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_postagem` (`id_categoria`);

--
-- Limitadores para a tabela `regiao_cidade`
--
ALTER TABLE `regiao_cidade`
  ADD CONSTRAINT `regiao_cidade_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `regiao_estado` (`id_regiao_estado`);

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_situacao`) REFERENCES `situacao_usuario` (`id_situacao_usuario`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`nivel`) REFERENCES `nivel_acesso` (`id_nivel`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`id_area`) REFERENCES `area_estudo` (`id_area`),
  ADD CONSTRAINT `usuarios_ibfk_4` FOREIGN KEY (`id_instituicao`) REFERENCES `instituicao_ensino` (`id_instituicao`),
  ADD CONSTRAINT `usuarios_ibfk_6` FOREIGN KEY (`id_regiao_cidade`) REFERENCES `regiao_cidade` (`id_regiao_cidade`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
