<footer>
    <div class="footer-container">
      <div class="footer-logo">
        <img src="imagenesong/logomascotar.png" alt="Logo MascotAR">
      </div>

      <div class="footer-section">
        <h3>Contactos</h3>
        <p><strong>Junta Directiva:</strong> Juan Pérez</p>
        <p><strong>Tel:</strong> 11 8822 8844</p>
        <p><strong>Email:</strong> info@mascotar.ong</p>
      </div>

      <div class="footer-section">
        <h3>Dónde estamos</h3>
        <p>Nos encontramos en Pilar,<br>Provincia de Buenos Aires.</p>
      </div>

      <div class="footer-section">
      <h3>Consultas</h3>
      <form action="procesar_consulta.php" method="post" class="footer-form">
        <input type="text" name="name" placeholder="Tu nombre" required minlength="2" maxlength="50" pattern="[A-Za-z\u00C0-\u017F\s']{2,50}" title="Solo letras, tildes, apóstrofos y espacios, de 2 a 50 caracteres.">
        <input type="email" name="email" placeholder="Email" required  minlength="6" maxlength="60" title="Email de 6 a 30 caracteres (incluyendo @).">
        <textarea name="msg" placeholder="Tu mensaje" required></textarea>
        <button type="submit">Enviar</button>
      </form>
    </div>
    </div>
  </footer>