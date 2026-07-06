<section class="page-header">
  <h1>Ajouter un document</h1>
</section>

<form class="form-card" method="post" enctype="multipart/form-data" action="/index.php?page=upload_document_submit">

  <input type="hidden" name="company_id" value="<?= $company_id ?>">

  <label>Titre du document *</label>
  <input type="text" name="title" required>

  <label>Fichier (PDF, DOCX) *</label>
  <input type="file" name="file" required>

  <button type="submit" class="btn-primary">Uploader ➤</button>

</form>
