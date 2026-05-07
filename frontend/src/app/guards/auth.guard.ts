import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

export const authGuard: CanActivateFn = () => {
  const auth   = inject(AuthService);
  const router = inject(Router);

  const token = auth.getToken();
  if (token && token.trim() !== '') {
    return true;
  }

  auth.logout();
  router.navigate(['/login']);
  return false;
};