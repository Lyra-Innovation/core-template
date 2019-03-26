import { Injectable, OnInit } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  Router,
  CanActivateChild
} from '@angular/router';
import { LoadFakeViewService } from 'projects/presenter/src/public_api';
import { Roles } from '../roles';
import { AuthService } from 'projects/presenter/src/lib/services/auth.service';

@Injectable()
export class RoleGuardService implements CanActivateChild {
  role: number;

  lastRoute: ActivatedRouteSnapshot;
  lastState: RouterStateSnapshot;

  constructor(
    protected loadViewService: LoadFakeViewService,
    protected auth: AuthService,
    private router: Router
  ) {
    this.loadRole();
  }

  loadRole() {
    this.loadViewService.loadView('status').subscribe(data => {
      if (data.response) {
        this.role = <number>(<unknown>data.response.children[0].values.role);
        this.canActivateChild(this.lastRoute, this.lastState);
      }
    });
  }

  canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    this.lastRoute = route;
    this.lastState = state;

    if (state.url === '/login' && this.auth.isAuthenticated()) {
      this.router.navigateByUrl('/loggedIn');
    } else if (state.url !== '/login' && !this.auth.isAuthenticated()) {
      this.router.navigateByUrl('/login');
    } else if (state.url === '/admin' && this.role !== Roles.ADMIN) {
      this.router.navigateByUrl('/loggedIn');
    } else if (state.url === '/dynamizer' && this.role !== Roles.DYNAMIZER) {
      this.router.navigateByUrl('/loggedIn');
    } else if (state.url === '/loggedIn') {
      if (this.role === Roles.ADMIN) {
        this.router.navigateByUrl('/admin');
      } else if (this.role === Roles.DYNAMIZER) {
        this.router.navigateByUrl('/dynamizer');
      } else if (this.role === Roles.USER) {
        this.router.navigateByUrl('/game/:$me/home');
      }
    }

    return true;
  }
}
