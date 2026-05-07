import { Routes } from '@angular/router';
import { authGuard } from './guards/auth.guard';

export const routes: Routes = [
  { path: '', redirectTo: '/login', pathMatch: 'full' },
  {
    path: 'login',
    loadComponent: () =>
      import('./views/login/login.component').then(m => m.LoginComponent),
  },
  {
    path: 'productos',
    loadComponent: () =>
      import('./views/products/products.component').then(m => m.ProductsComponent),
    canActivate: [authGuard],
  },
  { path: '**', redirectTo: '/login' },
];