function copySummary(text) {
  navigator.clipboard.writeText(text).then(() => {
    alert('Résumé copié dans le presse-papiers');
  }).catch(() => {
    alert('Impossible de copier');
  });
}
