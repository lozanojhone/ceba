document.addEventListener("DOMContentLoaded", function() {
  const tiles = document.querySelectorAll('.tile');

  tiles.forEach(tile => {
      tile.addEventListener('mouseenter', () => {
          tiles.forEach(t => {
              if (t !== tile) {
                  t.classList.add('blur'); // Agrega la clase de desenfoque a los otros tiles
              }
          });
          tile.classList.add('focused'); // Agrega la clase de enfoque al tile actual
      });

      tile.addEventListener('mouseleave', () => {
          tiles.forEach(t => {
              t.classList.remove('blur'); // Elimina la clase de desenfoque al salir
              t.classList.remove('focused'); // Elimina la clase de enfoque
          });
      });
  });
});