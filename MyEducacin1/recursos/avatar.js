function selectAvatar(avatar) {
    const selectedAvatarPreview = document.getElementById("selectedAvatarPreview");
    selectedAvatarPreview.src = avatar;
  }
  
  function saveAvatar() {
    const selectedAvatarPreview = document.getElementById("selectedAvatarPreview");
    const selectedAvatar = selectedAvatarPreview.src;
  
    // Aquí puedes realizar la lógica para guardar el avatar en la base de datos o realizar alguna acción con el avatar seleccionado
    console.log("Avatar seleccionado:", selectedAvatar);
  }
  