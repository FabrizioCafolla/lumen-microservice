file="./.env"
if [ ! -f "$file" ]
then
    cp ./.env.example .env
fi