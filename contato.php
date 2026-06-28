<?php
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 0);

$sucesso = false;
$dados_formulario = null;
$nome = $email = $assunto = $mensagem_usuario = $telefone = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = htmlspecialchars(trim($_POST['nome'] ?? ''), ENT_QUOTES, 'UTF-8');
  $email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
  $telefone = htmlspecialchars(trim($_POST['telefone'] ?? ''), ENT_QUOTES, 'UTF-8');
  $assunto = htmlspecialchars(trim($_POST['assunto'] ?? ''), ENT_QUOTES, 'UTF-8');
  $mensagem_usuario = htmlspecialchars(trim($_POST['mensagem'] ?? ''), ENT_QUOTES, 'UTF-8');
  $aceite = isset($_POST['aceite']) ? 1 : 0;

  if(empty($nome) || empty($email) || empty($assunto) || empty($mensagem_usuario) || !$aceite) {
    // Erro
  } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Email inválido
  } else {
    $sucesso = true;
    $dados_formulario = [
      'nome' => $nome,
      'email' => $email,
      'telefone' => $telefone,
      'assunto' => $assunto,
      'mensagem' => $mensagem_usuario
    ];
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
      <?php if($sucesso): ?>
        <!-- Página de Confirmação -->
        <div class="success-page">
          <div class="success-header">
            <div class="success-icon">✓</div>
            <h1>Mensagem Enviada com Sucesso!</h1>
            <p>Obrigado por entrar em contato conosco, <strong><?php echo $dados_formulario['nome']; ?></strong></p>
          </div>

          <div class="success-content">
            <h2>Confirmação de Envio</h2>
            
            <div class="confirmation-card">
              <div class="confirmation-row">
                <span class="label">Nome:</span>
                <span class="value"><?php echo $dados_formulario['nome']; ?></span>
              </div>
              <div class="confirmation-row">
                <span class="label">E-mail:</span>
                <span class="value"><?php echo $dados_formulario['email']; ?></span>
              </div>
              <?php if($dados_formulario['telefone']): ?>
              <div class="confirmation-row">
                <span class="label">Telefone:</span>
                <span class="value"><?php echo $dados_formulario['telefone']; ?></span>
              </div>
              <?php endif; ?>
              <div class="confirmation-row">
                <span class="label">Assunto:</span>
                <span class="value"><?php echo $dados_formulario['assunto']; ?></span>
              </div>
              <div class="confirmation-row full">
                <span class="label">Mensagem:</span>
                <span class="value message-box"><?php echo nl2br($dados_formulario['mensagem']); ?></span>
              </div>
            </div>

            <div class="success-info">
              <p>📧 Um email de confirmação foi enviado para <strong><?php echo $dados_formulario['email']; ?></strong></p>
              <p>⏱️ Nossa equipe responderá em até <strong>24 horas úteis</strong></p>
            </div>

            <div class="action-buttons">
              <a href="contato.php" class="btn btn-primary">Enviar Outra Mensagem</a>
              <a href="index.html" class="btn btn-secondary">Voltar ao Início</a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <!-- Formulário de Contato -->
        <h2 class="section-title">Contato</h2>
        <p>Envie sua mensagem para a ETEC. Tire dúvidas sobre cursos, matrículas, horários e processos seletivos.</p>

        <div class="form-grid">
          <div class="form-small">
            <form id="contactForm" action="contato.php" method="POST" novalidate>

              <div class="form-row">
                <div class="field">
                  <label for="nome">Nome completo <span aria-hidden="true">*</span></label>
                  <input type="text" id="nome" name="nome" autocomplete="name" placeholder="Seu nome" value="<?php echo isset($nome)?$nome:'';?>" required />
                  <span class="field-error" id="erro-nome" role="alert"></span>
                </div>
              </div>

              <div class="form-row two-col">
                <div class="field">
                  <label for="email">E-mail <span aria-hidden="true">*</span></label>
                  <input type="email" id="email" name="email" autocomplete="email" placeholder="voce@email.com" value="<?php echo isset($email)?$email:'';?>" required />
                  <span class="field-error" id="erro-email" role="alert"></span>
                </div>
                <div class="field">
                  <label for="telefone">Telefone</label>
                  <input type="tel" id="telefone" name="telefone" autocomplete="tel" placeholder="(00) 00000-0000" maxlength="15" value="<?php echo isset($telefone)?$telefone:'';?>" />
                </div>
              </div>

              <div class="form-row">
                <div class="field">
                  <label for="assunto">Assunto <span aria-hidden="true">*</span></label>
                  <select id="assunto" name="assunto" required>
                    <option value="">Selecione...</option>
                    <option value="suporte">Suporte técnico</option>
                    <option value="comercial">Proposta comercial</option>
                    <option value="parceria">Parceria</option>
                    <option value="outro">Outro</option>
                  </select>
                  <span class="field-error" id="erro-assunto" role="alert"></span>
                </div>
              </div>

              <div class="form-row">
                <div class="field">
                  <label for="mensagem">Mensagem <span aria-hidden="true">*</span></label>
                  <textarea id="mensagem" name="mensagem" rows="5" placeholder="Descreva seu assunto..." required><?php echo isset($mensagem_usuario)?$mensagem_usuario:'';?></textarea>
                  <span class="field-error" id="erro-mensagem" role="alert"></span>
                  <span class="char-count" id="charCount">0 / 500</span>
                </div>
              </div>

              <div class="form-row privacy-row">
                <label class="checkbox-label">
                  <input type="checkbox" name="aceite" id="aceite" required />
                  <span class="checkmark"></span>
                  Concordo com a <a href="#">Política de Privacidade</a>
                </label>
                <span class="field-error" id="erro-aceite" role="alert"></span>
              </div>

              <div class="form-footer">
                <button type="submit" id="submitBtn">
                  <span class="btn-text">Enviar mensagem</span>
                  <span class="btn-loader" aria-hidden="true"></span>
                </button>
              </div>

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
      <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container footer-content">
      <div class="footer-box footer-brand">
        <img src="img/eteczl.jpeg" alt="Logo ETEC" />
        <p>ETEC Zona Leste<br>CPS - Centro Paula Souza</p>
      </div>

      <div class="footer-box footer-contact">
        <h4>Contato</h4>
        <p>Av. dos Trabalhadores, 1234<br>São Paulo, SP</p>
        <p>Tel: (11) 5555-1234<br>Email: contato@etec.sp.gov.br</p>
      </div>

      <div class="footer-box footer-links">
        <h4>Links úteis</h4>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="sobre.html">Sobre</a></li>
          <li><a href="cursos.html">Cursos</a></li>
          <li><a href="contato.php">Contato</a></li>
        </ul>
      </div>

      <div class="footer-box footer-social">
        <h4>Siga-nos</h4>
        <p>
          <a href="https://www.facebook.com/CPS" target="_blank" rel="noopener noreferrer">Facebook</a><br>
          <a href="https://www.instagram.com/centropaulasouza" target="_blank" rel="noopener noreferrer">Instagram</a><br>
          <a href="https://www.youtube.com/user/centropaulasouza" target="_blank" rel="noopener noreferrer">YouTube</a>
        </p>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2026 ETEC - Centro Paula Souza. Todos os direitos reservados.</p>
    </div>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>
