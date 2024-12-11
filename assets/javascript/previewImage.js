/**
 * Função para preview da imagem do perfil do funcionário
 * @param {HTMLInputElement} input - O elemento input que contém a imagem
 */
function previewImage(input) {
  const file = input.files[0];
  const reader = new FileReader();
  reader.onload = function(e) {
    const img = document.querySelector('img#foto_perfil');
    img.src = e.target.result;
  };
  reader.readAsDataURL(file);
}