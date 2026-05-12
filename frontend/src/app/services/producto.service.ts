import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Producto } from '../models/producto.model';

@Injectable({ providedIn: 'root' })
export class ProductoService {
  private apiUrl = 'http://localhost/tienda-app/backend/api/productos'; // Esto hay que cargarlo desde un arhcivo
  // con las variables de entorno tambien

  constructor(private http: HttpClient) {}

  getProductos(): Observable<Producto[]> { // 
    return this.http.get<Producto[]>(this.apiUrl);
  }

  eliminar(id: number): Observable<any> { // Cuando usamos TypeScript se evita utilizar any ya que la funcion principal
    // para usarlo es justamente por el tipado, asi que hay que crear una interface con la respuesta como lo hiciste arriba
    return this.http.delete(`${this.apiUrl}/${id}`);
  }

  actualizar(id: number, producto: Partial<Producto>): Observable<any> { // Aqui igual hay que tipar con TS la respuuesta
    return this.http.put(`${this.apiUrl}/${id}`, producto);
  }
}