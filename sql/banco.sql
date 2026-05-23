CREATE DATABASE IF NOT EXISTS alexandria DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE alexandria;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS emprestimos;
DROP TABLE IF EXISTS livros;
DROP TABLE IF EXISTS autores;
DROP TABLE IF EXISTS leitores;
DROP TABLE IF EXISTS funcionarios;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE leitores (
    id_leitor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    cpf VARCHAR(20),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE funcionarios (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    cargo VARCHAR(60),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(80),
    biografia TEXT
);

CREATE TABLE livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    id_autor INT NOT NULL,
    editora VARCHAR(100),
    categoria VARCHAR(80),
    ano_publicacao INT,
    quantidade INT DEFAULT 0,
    descricao TEXT,
    imagem VARCHAR(255),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_autor) REFERENCES autores(id_autor)
);

CREATE TABLE emprestimos (
    id_emprestimo INT AUTO_INCREMENT PRIMARY KEY,
    id_leitor INT NOT NULL,
    id_livro INT NOT NULL,
    data_solicitacao DATE,
    data_emprestimo DATE,
    data_devolucao DATE,
    status ENUM('pendente', 'aprovado', 'recusado', 'devolvido') DEFAULT 'pendente',
    FOREIGN KEY (id_leitor) REFERENCES leitores(id_leitor),
    FOREIGN KEY (id_livro) REFERENCES livros(id_livro)
);

INSERT INTO funcionarios (nome, email, senha, telefone, cargo) VALUES
('Funcionário', 'funcionario@alexandria.com', '123456', '(18) 99999-0000', 'Bibliotecário');

INSERT INTO leitores (nome, email, senha, telefone, cpf) VALUES
('Henrique', 'leitor@alexandria.com', '123456', '(18) 98888-0000', '000.000.000-00');

INSERT INTO autores (nome, nacionalidade, biografia) VALUES
('Machado de Assis', 'Brasileira', 'Escritor brasileiro conhecido por romances, contos e crônicas.'),
('Júlio Verne', 'Francesa', 'Autor conhecido por obras de aventura e ficção científica.'),
('Mary Shelley', 'Britânica', 'Escritora conhecida por obras de ficção gótica.'),
('José de Alencar', 'Brasileira', 'Importante autor do romantismo brasileiro.'),
('Lima Barreto', 'Brasileira', 'Escritor brasileiro conhecido por sua crítica social.'),
('Clarice Lispector', 'Brasileira', 'Escritora reconhecida por sua escrita introspectiva e psicológica.'),
('George Orwell', 'Britânica', 'Autor conhecido por obras de ficção política e distópica.'),
('Antoine de Saint-Exupéry', 'Francesa', 'Escritor e aviador francês conhecido por obras poéticas e filosóficas.'),
('Jane Austen', 'Britânica', 'Romancista conhecida por obras sobre sociedade, família e relações humanas.'),
('Dante Alighieri', 'Italiana', 'Poeta italiano conhecido como um dos grandes nomes da literatura mundial.');

INSERT INTO livros (titulo, id_autor, editora, categoria, ano_publicacao, quantidade, descricao, imagem) VALUES
('Dom Casmurro', 1, 'Editora Exemplo', 'Romance', 1899, 3, 'Romance clássico da literatura brasileira que acompanha a história de Bentinho e Capitu.', 'assets/img/dom_casmurro.webp'),
('Vinte Mil Léguas Submarinas', 2, 'Editora Exemplo', 'Aventura', 1870, 2, 'Uma aventura pelo fundo do mar a bordo do submarino Náutilus.', 'assets/img/vinte_mil_leguas_submarinas.webp'),
('Frankenstein', 3, 'Editora Exemplo', 'Ficção', 1818, 4, 'Obra clássica sobre criação, responsabilidade e consequências da ciência.', 'assets/img/frankenstein.webp'),
('Iracema', 4, 'Editora Exemplo', 'Romance', 1865, 3, 'Romance indianista brasileiro que apresenta uma narrativa poética sobre origem, amor e conflito.', 'assets/img/iracema.webp'),
('Triste Fim de Policarpo Quaresma', 5, 'Editora Exemplo', 'Literatura Brasileira', 1915, 2, 'Obra que acompanha Policarpo Quaresma e sua visão idealista sobre o Brasil.', 'assets/img/triste_fim_de_policarpo_quaresma.webp'),
('A Hora da Estrela', 6, 'Editora Exemplo', 'Romance', 1977, 3, 'Narrativa sobre Macabéa, uma jovem nordestina vivendo no Rio de Janeiro.', 'assets/img/a_hora_da_estrela.webp'),
('A Revolução dos Bichos', 7, 'Editora Exemplo', 'Fábula Política', 1945, 4, 'Fábula política que usa animais de uma fazenda para discutir poder e autoritarismo.', 'assets/img/a_revolucao_dos_bichos.webp'),
('O Pequeno Príncipe', 8, 'Editora Exemplo', 'Infantojuvenil', 1943, 5, 'Livro poético e filosófico sobre amizade, imaginação e descobertas.', 'assets/img/o_pequeno_principe.webp'),
('Orgulho e Preconceito', 9, 'Editora Exemplo', 'Romance', 1813, 2, 'Romance clássico que aborda relações sociais, família e julgamentos pessoais.', 'assets/img/orgulho_e_preconceito.webp'),
('A Divina Comédia', 10, 'Editora Exemplo', 'Poesia Épica', 1321, 2, 'Poema clássico que narra uma jornada simbólica pelo Inferno, Purgatório e Paraíso.', 'assets/img/a_divina_comedia.webp');