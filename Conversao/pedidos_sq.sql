CREATE TABLE pedidos (
    id   INTEGER PRIMARY KEY autoincrement,
    data date    NOT NULL,
    quantidade integer not null,
    produto_id      INTEGER,
    FOREIGN KEY (produto_id) REFERENCES produtos (id) ON UPDATE RESTRICT ON DELETE RESTRICT
);

