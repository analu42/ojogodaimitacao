use turing;

create table registros(
	id int AUTO_INCREMENT primary key,
    codigo VARCHAR(3) not null,
    pergunta TEXT not null,
    data_hora_pergunta DATETIME not null,
    resposta TEXT,
    resposta_gemini TEXT,
    data_hora_resposta DATETIME
);