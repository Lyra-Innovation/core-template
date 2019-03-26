import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { MobileShellComponent, RouteContainerComponent } from 'renderer';
import { GameStatusGuardService } from './custom/game-status-guard.service';
import { RoleGuardService } from './custom/role-guard.service';

const routes: Routes = [
  {
    path: '',
    component: MobileShellComponent,
    canActivateChild: [RoleGuardService],
    children: [
      {
        path: '',
        redirectTo: 'login',
        pathMatch: 'full'
      },
      {
        path: 'game/:gameuserid',
        component: RouteContainerComponent,
        canActivateChild: [GameStatusGuardService],
        children: [
          {
            path: '',
            redirectTo: 'home',
            pathMatch: 'full'
          }
        ]
      },
      {
        path: 'loggedIn',
        component: RouteContainerComponent
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: [GameStatusGuardService, RoleGuardService]
})
export class AppRoutingModule {}
