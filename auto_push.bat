git add .
git commit -m "Production with .htaccess commit %date: %date% time: %time%"
git pull origin main
:: merging to avoid conflicts
git merge
:: Pushing on the main branch of the repository 
git push origin main