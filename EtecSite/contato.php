<?php
$mensagem = '';
$nome = $email = $curso = $mensagem_usuario = '';

if(isset($_GET['curso']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
  $curso = trim(filter_input(INPUT_GET, 'curso', FILTER_SANITIZE_STRING));
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
  $fone = trim(filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING));
  $curso = trim(filter_input(INPUT_POST, 'curso', FILTER_SANITIZE_STRING));
  $mensagem_usuario = trim(filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING));

  if(empty($nome) || empty($email) || empty($curso) || empty($mensagem_usuario)) {
    $mensagem = '<div class="alert" style="background:#fce8e8;color:#7a1b1b;border-color:#f1aeb0;">Por favor, preencha todos os campos obrigatórios (nome, e-mail, curso, mensagem).</div>';
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mensagem = '<div class="alert" style="background:#fce8e8;color:#7a1b1b;border-color:#f1aeb0;">E-mail inválido.</div>';
  } else {
    $telefoneConfirm = !empty($fone) ? "Telefone: <strong>".htmlspecialchars($fone)."</strong>.<br>" : '';
    $mensagem = "<div class='alert'>Obrigado, <strong>".htmlspecialchars($nome)."</strong>.<br>Sua mensagem foi recebida com sucesso!<br>".
                "Curso: <strong>".htmlspecialchars($curso)."</strong>.<br>".$telefoneConfirm."Nossa equipe entrará em contato em breve.</div>";
    $nome = $email = $fone = $curso = $mensagem_usuario = '';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ETEC - Contato</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header>
    <div class="container">
      <div class="logo">ETEC</div>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="sobre.html">Sobre Nós</a></li>
          <li><a href="cursos.html">Cursos</a></li>
          <li><a href="contato.php">Contato</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <section class="container">
      <h2 class="section-title">Contato</h2>
      <p>Envie sua mensagem para a ETEC. Tire dúvidas sobre cursos, matrículas, horários e processos seletivos.</p>
      <?php if(!empty($curso)): ?>
        <p style="font-weight:700;color:#c30000;">Curso selecionado: <?php echo htmlspecialchars($curso); ?></p>
      <?php endif; ?>
      <?php if($mensagem) echo $mensagem; ?>

      <div class="form-grid">
        <div class="form-small">
          <form action="contato.php" method="POST">
        <label for="nome">Nome</label>
        <input id="nome" name="nome" type="text" value="<?php echo isset($nome)?htmlspecialchars($nome):'';?>" required />

        <label for="email">E-mail</label>
        <input id="email" name="email" type="email" value="<?php echo isset($email)?htmlspecialchars($email):'';?>" required />

        <label for="curso">Curso de interesse</label>
        <input id="curso" name="curso" type="text" value="<?php echo isset($curso)?htmlspecialchars($curso):'';?>" required />

        <label for="fone">Telefone (opcional)</label>
        <input id="fone" name="fone" type="tel" placeholder="(00) 00000-0000" />

        <label for="mensagem">Mensagem</label>
        <textarea id="mensagem" name="mensagem" rows="5" required><?php echo isset($mensagem_usuario)?htmlspecialchars($mensagem_usuario):'';?></textarea>

        <button type="submit">Enviar Mensagem</button>
      </form>
    </div>

    <div class="info-panel">
      <h3>Informações de contato</h3>
      <p>Acesse o canal oficial e tire todas as suas dúvidas com a equipe da ETEC.</p>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:14px;">
        <div>
          <p><strong>Endereço</strong><br/>Av. Exemplo, 1000 - Centro, São Paulo - SP</p>
        </div>
        <div>
          <p><strong>Telefone</strong><br/>(11) 1234-5678</p>
        </div>
        <div>
          <p><strong>Email</strong><br/>contato@etec.com.br</p>
        </div>
        <div>
          <p><strong>Atendimento</strong><br/>Segunda a sexta, das 8h às 18h</p>
        </div>
        <div>
          <p><strong>Redes sociais</strong><br/>@etec_oficial</p>
        </div>
        <div>
          <p><strong>WhatsApp</strong><br/>(11) 9 8765-4321</p>
        </div>
      </div>
    </div>
  </div>
    </section>
  </main>

  <footer>
    <div class="container">ETEC - Escola Técnica | © 2026</div>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>
