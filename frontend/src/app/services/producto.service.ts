import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { Producto, ApiResponse } from '../models/producto.model';
import { environment } from '../../environments/environment';

@Injectable({ providedIn: 'root' })
export class ProductoService {
  private apiUrl = `${environment.apiUrl}/productos`;

  constructor(private http: HttpClient) {}

  getProductos(): Observable<Producto[]> {
    return this.http.get<{ status: string; data: Producto[] }>(this.apiUrl).pipe(
      map(res => res.data)
    );
  }

  eliminar(id: number): Observable<ApiResponse> {
    return this.http.delete<{ status: string; data: ApiResponse }>(`${this.apiUrl}/${id}`).pipe(
      map(res => res.data)
    );
  }

  actualizar(id: number, producto: Partial<Producto>): Observable<ApiResponse> {
    return this.http.put<{ status: string; data: ApiResponse }>(`${this.apiUrl}/${id}`, producto).pipe(
      map(res => res.data)
    );
  }
}