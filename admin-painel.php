<?php
session_start();
require_once 'conexao.php';


if (!isset($_SESSION['logged']) || $_SESSION['is_admin'] != 1) {
    die("Acesso negado. Apenas administradores podem acessar esta página.");
}

$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_reservation'])) {
    $id = intval($_POST['reservation_id']);
    if ($_POST['action_reservation'] === 'update_date') {
        $newDate = $_POST['new_datehour'] ?? '';
        if ($newDate) {
            $stmt = $pdo->prepare("UPDATE tb_psa_reservation SET reservation_datehour = :newdate WHERE id_reservation = :id");
            $stmt->execute(['newdate' => $newDate, 'id' => $id]);
            $message = "Data da reserva #$id atualizada!";
        }
    } elseif ($_POST['action_reservation'] === 'cancel') {
        $stmt = $pdo->prepare("UPDATE tb_psa_reservation SET reservation_status = 'Cancelado' WHERE id_reservation = :id");
        $stmt->execute(['id' => $id]);
        $message = "Reserva #$id cancelada!";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_content'])) {
    $key = $_POST['content_key'] ?? '';
    $text = $_POST['content_text'] ?? '';
    if ($key) {
        $stmt = $pdo->prepare("UPDATE tb_psa_pageContent SET content_text = :text WHERE content_key = :key");
        $stmt->execute(['text' => $text, 'key' => $key]);
        $message = "Conteúdo '$key' atualizado!";
    }
}

$stmt = $pdo->prepare("
    SELECT r.*, u.user_name, u.user_email 
    FROM tb_psa_reservation r 
    JOIN tb_psa_user u ON r.id_user = u.id_user
    ORDER BY r.reservation_datehour DESC
");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==================== BUSCA CONTEÚDOS ====================
$stmt = $pdo->prepare("SELECT content_key, content_text FROM tb_psa_pageContent");
$stmt->execute();
$contents = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { border-bottom: 2px solid #ccc; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        textarea { width: 100%; height: 80px; }
        form.inline { display: inline; }
        .message { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px; }
    </style>
</head>
<body onload="Menu()">

    <h1>Painel do Administrador</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Seção: Gerenciamento de Reservas -->
    <section>
        <h2>Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Local</th>
                    <th>Qtd Pessoas</th>
                    <th>Data e Hora</th>
                    <th>Status</th>
                    <th>Alterar Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                <tr>
                    <td><?= $r['id_reservation'] ?></td>
                    <td><?= htmlspecialchars($r['user_name']) ?></td>
                    <td><?= htmlspecialchars($r['user_email']) ?></td>
                    <td><?= htmlspecialchars($r['reservation_local']) ?></td>
                    <td><?= $r['people_quantity'] ?></td>
                    <td><?= $r['reservation_datehour'] ?></td>
                    <td><?= htmlspecialchars($r['reservation_status']) ?></td>
                    <td>
                        <form method="POST" class="inline">
                            <input type="hidden" name="reservation_id" value="<?= $r['id_reservation'] ?>">
                            <input type="datetime-local" name="new_datehour" required>
                            <input type="hidden" name="action_reservation" value="update_date">
                            <button type="submit">Alterar</button>
                        </form>
                    </td>
                    <td>
                        <?php if ($r['reservation_status'] !== 'Cancelado'): ?>
                        <form method="POST" class="inline" onsubmit="return confirm('Cancelar reserva #<?= $r['id_reservation'] ?>?');">
                            <input type="hidden" name="reservation_id" value="<?= $r['id_reservation'] ?>">
                            <input type="hidden" name="action_reservation" value="cancel">
                            <button type="submit" style="background:#e74c3c; color:#fff;">Cancelar</button>
                        </form>
                        <?php else: ?>
                            Cancelada
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($reservations)): ?>
                <tr><td colspan="9">Nenhuma reserva encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <!-- Seção: Edição do Conteúdo da Página Inicial -->
    <section>
        <h2>Editar Conteúdo da Página Inicial</h2>
        <?php foreach ($contents as $key => $text): ?>
            <form method="POST" style="margin-bottom: 30px;">
                <label for="<?= $key ?>"><strong><?= ucfirst(str_replace('_', ' ', $key)) ?>:</strong></label><br>
                <textarea name="content_text" id="<?= $key ?>"><?= htmlspecialchars($text) ?></textarea><br>
                <input type="hidden" name="content_key" value="<?= htmlspecialchars($key) ?>">
                <input type="hidden" name="action_content" value="update">
                <button type="submit">Salvar <?= ucfirst(str_replace('_', ' ', $key)) ?></button>
            </form>
        <?php endforeach; ?>
    </section>
    <script src="js/script-menu.js" defer></script>
</body>
</html>
