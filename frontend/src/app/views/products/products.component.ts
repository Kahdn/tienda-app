import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { Producto } from '../../models/producto.model';
import { ProductoService } from '../../services/producto.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-products',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.css'],
})
export class ProductsComponent implements OnInit {
  productos: Producto[] = [];
  cargando  = true;
  error     = '';
  esAdmin   = false;
  username  = '';

  modalAbierto   = false;
  productoEditar: Partial<Producto> = {};
  guardando      = false;

  constructor(
    private productoSvc: ProductoService,
    private auth: AuthService,
    private router: Router
  ) {}

  ngOnInit(): void {
    const usuario  = this.auth.getUsuario();
    this.esAdmin   = this.auth.esAdmin();
    this.username  = usuario?.username ?? '';
    this.cargarProductos();
  }

  cargarProductos(): void {
    this.cargando = true;
    this.productoSvc.getProductos().subscribe({
      next: (data) => { this.productos = data; this.cargando = false; },
      error: ()     => { this.error = 'Error al cargar productos.'; this.cargando = false; },
    });
  }

  abrirEdicion(p: Producto): void {
    this.productoEditar = { ...p };
    this.modalAbierto   = true;
  }

  cerrarModal(): void {
    this.modalAbierto   = false;
    this.productoEditar = {};
  }

  guardarEdicion(): void {
    if (!this.productoEditar.id) return;
    this.guardando = true;

    this.productoSvc.actualizar(this.productoEditar.id, this.productoEditar).subscribe({
      next: () => {
        this.guardando = false;
        this.cerrarModal();
        this.cargarProductos();
      },
      error: () => { this.guardando = false; },
    });
  }

  eliminar(id: number): void {
    if (!confirm('¿Seguro que deseas eliminar este producto?')) return;

    this.productoSvc.eliminar(id).subscribe({
      next: () => this.cargarProductos(),
      error: () => alert('Error al eliminar el producto.'),
    });
  }

  logout(): void {
    this.auth.logout();
    this.router.navigate(['/login']);
  }
}