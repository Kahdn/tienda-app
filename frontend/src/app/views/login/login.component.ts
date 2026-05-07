import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent {
  username = '';
  password = '';
  errorMsg = '';
  cargando = false;

  constructor(private auth: AuthService, private router: Router) {
    if (this.auth.estaLogueado()) {
      this.router.navigate(['/productos']);
    }
  }

  login(): void {
    if (!this.username || !this.password) {
      this.errorMsg = 'Por favor, completa todos los campos.';
      return;
    }

    this.cargando = true;
    this.errorMsg = '';

    this.auth.login({ username: this.username, password: this.password }).subscribe({
      next: (res) => {
        this.cargando = false;
        if (res && res.token) {
          this.router.navigate(['/productos']);
        } else {
          this.errorMsg = 'Credenciales incorrectas. Verifica tu usuario y contraseña.';
        }
      },
      error: (err) => {
        this.cargando = false;
        this.errorMsg =
          err.status === 401 || err.status === 400
            ? 'Credenciales incorrectas. Verifica tu usuario y contraseña.'
            : 'Error al conectar con el servidor.';
      },
    });
  }
}