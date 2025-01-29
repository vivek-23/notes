git checkout {branch name}

git rev-parse --abbrev-ref --symbolic-full-name @{u} | cut -d'/' -f1
