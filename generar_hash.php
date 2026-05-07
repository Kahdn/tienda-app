<?php
echo "admin123: " . password_hash('admin123', PASSWORD_BCRYPT) . "\n";
echo "user123: "  . password_hash('user123',  PASSWORD_BCRYPT) . "\n";