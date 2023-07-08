<?php
require_once 'database.php';

function atualizarEstoque($json)
{
    $pdo = Database::getConnection();

    $produtos = json_decode($json, true);

    $insertQuery = "INSERT INTO estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade) 
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE quantidade = ?";

    $pdo->beginTransaction();

    try {
       
        if (!empty($produtos) && is_array($produtos)) {
            foreach ($produtos as $produto) {
                $stmt = $pdo->prepare($insertQuery);
                $stmt->execute([
                    $produto['produto'],
                    $produto['cor'],
                    $produto['tamanho'],
                    $produto['deposito'],
                    $produto['data_disponibilidade'],
                    $produto['quantidade'],
                    $produto['quantidade']
                ]);
            }
        } else {
            echo "Nenhum produto encontrado no JSON.";
        }

        $pdo->commit();

        echo "Atualização de estoque concluída com sucesso!";

    } catch (PDOException $e) {

        $pdo->rollBack();
        die("Erro ao atualizar o estoque: " . $e->getMessage());
    }
}

$json ='[
    {
    "produto": "10.01.0419",
    "cor": "00",
    "tamanho": "P",
    "deposito": "DEP1",
    "data_disponibilidade": "2023-05-01",
    "quantidade": 12
    },
    {
    "produto": "11.01.0568",
    "cor": "08",
    "tamanho": "P",
    "deposito": "DEP1",
    "data_disponibilidade": "2023-05-01",
    "quantidade": 5
    },
    {
    "produto": "11.01.0568",
    "cor": "08",
    "tamanho": "M",
    "deposito": "DEP1",
    "data_disponibilidade": "2023-05-01",
    "quantidade": 3
    },
    {
    "produto": "11.01.0568",
    "cor": "08",
    "tamanho": "G",
    "deposito": "1",
    "data_disponibilidade": "2023-05-01",
    "quantidade": 25
    },
    {
    "produto": "11.01.0568",
    "cor": "08",
    "tamanho": "P",
    "deposito": "DEP1",
    "data_disponibilidade": "2023-06-01",
    "quantidade": 1
    }
]';

atualizarEstoque($json);
?>
