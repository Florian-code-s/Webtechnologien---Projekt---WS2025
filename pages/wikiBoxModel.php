<section class="container py-5">
  <div class="row">
    <div class="col-12">
      <h1>CSS Box Model</h1>
      <p class="lead">Jedes Element wird als Box behandelt: Inhalt (content), Padding, Border und Margin. Die Größe eines Elements ergibt sich aus diesen Teilen.</p>

      <h2>Aufbau</h2>
      <ol>
        <li><strong>Content:</strong> Breite und Höhe des Inhalts.</li>
        <li><strong>Padding:</strong> Abstand zwischen Inhalt und Rahmen.</li>
        <li><strong>Border:</strong> Der sichtbare Rahmen um das Element.</li>
        <li><strong>Margin:</strong> Abstand zu anderen Elementen außerhalb des Rahmens.</li>
      </ol>

      <h2>Box‑Sizing</h2>
      <p>Mit <code>box-sizing: border-box;</code> wird Padding und Border zur Gesamtbreite hinzugerechnet — oft nützlich für Layouts.</p>

      <pre><code>/* empfohlene Grundeinstellung */
*, *::before, *::after { box-sizing: border-box; }</code></pre>

      <p><a href="?page=wiki" class="btn btn-secondary">Zurück zur Übersicht</a></p>
    </div>
  </div>
</section>