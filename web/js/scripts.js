function confirm_delete(rom) {
    return confirm('Delete ' + rom + '?'); 
}

function load_file() {
    var file = document.getElementById("rom_file").files;

    document.getElementById("submit_rom").value = file[0].name;

}
