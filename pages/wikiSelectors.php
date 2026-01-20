

<section class="container py-5">
  <div class="row">
    <div class="col-12">
      <h1>CSS Selectors</h1>
      <p class="lead">Selectors bestimmen, welche HTML‑Elemente von einer CSS‑Regel betroffen sind. Du kannst einfache Selektoren wie Tag‑, Klassen‑ oder ID‑Selektoren verwenden oder komplexere kombinierte Selektoren.</p>

      <h2>Grundtypen</h2>
      <ul>
        <li><strong>Tag:</strong> <code>p { ... }</code> — alle &lt;p&gt;-Elemente</li>
        <li><strong>Klasse:</strong> <code>.btn { ... }</code> — alle Elemente mit <code>class="btn"</code></li>
        <li><strong>ID:</strong> <code>#nav { ... }</code> — Element mit <code>id="nav"</code></li>
        <li><strong>Attribut:</strong> <code>a[target="_blank"] { ... }</code></li>
      </ul>

      <h2>Kombinierte Selektoren</h2>
      <p>Eltern‑Kind, Nachbar‑Selektoren und Pseudoklassen:</p>
      <pre><code>header nav a:hover { color: red; }
ul > li { list-style: none; }
input[type="text"]:focus { outline: none; }</code></pre>

      <h2>Tipps</h2>
      <ul>
        <li>Verwende Klassen für wiederverwendbare Komponenten.</li>
        <li>Bevorzuge spezifitätsarme Selektoren, um spätere Überschreibungen zu erleichtern.</li>
        <li>Nutze Tools wie die Browser‑DevTools, um Selektoren zu testen.</li>
      </ul>

      <p><a href="?page=wiki" class="btn btn-secondary">Zurück zur Übersicht</a></p>
    </div>
  </div>
</section>