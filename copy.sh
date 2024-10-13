#!/bin/bash

# Dossier source et destination
SRC_DIR="node_modules"
DEST_DIR="resources/js/vendor"

# Créer le dossier de destination s'il n'existe pas
mkdir -p "$DEST_DIR"

# Fichiers à copier (structure clé-valeur: chemin dans node_modules -> chemin dans resources/js/vendor)
declare -A files=(
    ["jquery/dist/jquery.min.js"]="$DEST_DIR/jquery.min.js"
    ["popper.js/dist/umd/popper.min.js"]="$DEST_DIR/popper.min.js"
    ["bootstrap/dist/js/bootstrap.min.js"]="$DEST_DIR/bootstrap.min.js"
    ["headroom.js/dist/headroom.min.js"]="$DEST_DIR/headroom.min.js"
    ["onscreen/dist/on-screen.umd.min.js"]="$DEST_DIR/on-screen.umd.min.js"
    ["nouislider/distribute/nouislider.min.js"]="$DEST_DIR/nouislider.min.js"
    ["bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"]="$DEST_DIR/bootstrap-datepicker.min.js"
    ["waypoints/lib/jquery.waypoints.min.js"]="$DEST_DIR/jquery.waypoints.min.js"
    ["jarallax/dist/jarallax.min.js"]="$DEST_DIR/jarallax.min.js"
    ["jquery.counterup/jquery.counterup.min.js"]="$DEST_DIR/jquery.counterup.min.js"
    ["jquery-countdown/dist/jquery.countdown.min.js"]="$DEST_DIR/jquery.countdown.min.js"
    ["smooth-scroll/dist/smooth-scroll.polyfills.min.js"]="$DEST_DIR/smooth-scroll.polyfills.min.js"
    ["prismjs/prism.js"]="$DEST_DIR/prism.js"
)

# Vérifier et copier chaque fichier
for src in "${!files[@]}"; do
    src_path="$SRC_DIR/$src"
    dest_path="${files[$src]}"
    
    if [ -f "$src_path" ]; then
        echo "Copie de $src_path vers $dest_path"
        cp --parents "$src_path" "$DEST_DIR"
    else
        echo "Erreur : $src_path non trouvé dans node_modules."
    fi
done

echo "Copie terminée."
