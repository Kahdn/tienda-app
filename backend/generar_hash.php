<?php
echo "admin123: " . password_hash('admin123', PASSWORD_BCRYPT) . "\n";
echo "user123: "  . password_hash('user123',  PASSWORD_BCRYPT) . "\n";

// Este archivo no deberia ir aqui hay que eliminarlo, en todo caso deberia ir en el backend