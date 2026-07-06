<div class="page-header">
  <h1>📤 Ajouter un document</h1>
  <p>Téléchargez un document pour l'entreprise</p>
</div>

<div class="card form-card" style="max-width: 600px;">
  <form method="post" enctype="multipart/form-data" action="/index.php?page=upload_document_submit">
    
    <input type="hidden" name="company_id" value="<?= (int)$company_id ?>">

    <div class="form-group">
      <label for="title">Titre du document *</label>
      <input 
        type="text" 
        id="title"
        name="title" 
        placeholder="Ex: Contrat de service, Facture, etc." 
        required
      >
    </div>

    <div class="form-group">
      <label for="file">Fichier *</label>
      <div style="padding: 32px; border: 2px dashed var(--blue-light); border-radius: var(--radius-md); text-align: center; background: var(--gray-50); cursor: pointer; transition: var(--transition);" id="dropZone">
        <input 
          type="file" 
          id="file"
          name="file"
          accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"
          required
          style="display: none;"
        >
        <div style="font-size: 32px; margin-bottom: 12px;">📁</div>
        <p style="margin: 8px 0; color: var(--gray-700); font-weight: 500;">
          Cliquez ou glissez-déposez un fichier
        </p>
        <p style="margin: 4px 0 0 0; color: var(--gray-500); font-size: 13px;">
          PDF, DOCX, XLS, XLSX (max 50 MB)
        </p>
      </div>
      <div id="fileName" style="margin-top: 12px; color: var(--blue-primary); font-weight: 500; display: none;"></div>
    </div>

    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px;">
      <a href="/index.php?page=companies" class="btn btn-secondary">Annuler</a>
      <button type="submit" class="btn btn-primary btn-lg">✓ Télécharger</button>
    </div>

  </form>
</div>

<script>
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('file');
  const fileName = document.getElementById('fileName');

  dropZone.addEventListener('click', () => fileInput.click());

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = 'var(--blue-light)';
    dropZone.style.opacity = '0.8';
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.style.backgroundColor = '';
    dropZone.style.opacity = '1';
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    dropZone.style.opacity = '1';
    
    if (e.dataTransfer.files.length > 0) {
      fileInput.files = e.dataTransfer.files;
      updateFileName();
    }
  });

  fileInput.addEventListener('change', updateFileName);

  function updateFileName() {
    if (fileInput.files.length > 0) {
      const name = fileInput.files[0].name;
      fileName.textContent = '✓ ' + name + ' sélectionné';
      fileName.style.display = 'block';
    } else {
      fileName.style.display = 'none';
    }
  }
</script>