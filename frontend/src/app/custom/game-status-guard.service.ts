import { Injectable, OnInit } from '@angular/core';
import {
  ActivatedRouteSnapshot,
  RouterStateSnapshot,
  Router,
  CanActivateChild
} from '@angular/router';
import { GameStatus } from '../game-status';
import { LoadFakeViewService } from 'projects/presenter/src/public_api';

@Injectable()
export class GameStatusGuardService implements CanActivateChild {
  gameStatus: number;

  lastRoute: ActivatedRouteSnapshot;
  lastState: RouterStateSnapshot;

  constructor(
    protected loadViewService: LoadFakeViewService,
    private router: Router
  ) {
    this.loadViewService.loadView('status').subscribe(data => {
      if (data.response) {
        this.gameStatus = <number>(
          (<unknown>data.response.children[0].values.status)
        );
        this.canActivateChild(this.lastRoute, this.lastState);
      }
    });
  }

  canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    this.lastRoute = route;
    this.lastState = state;

    if (this.gameStatus === GameStatus.PENDING_INIT) {
      this.router.navigateByUrl('/setup');
    } else if (
      this.gameStatus === GameStatus.PENDING_VALIDATION &&
      !state.url.includes('waiting-setup-validation')
    ) {
      this.router.navigateByUrl('/game/:$me/waiting-setup-validation');
    } else if (
      (this.gameStatus === GameStatus.FINISHED ||
        this.gameStatus === GameStatus.PLAYING) &&
      (state.url.includes('waiting') || state.url.includes('setup'))
    ) {
      this.router.navigateByUrl('/game/:$me/home');
    } else if (
      this.gameStatus === GameStatus.PENDING_REVIEW &&
      !state.url.includes('waiting-game-validation')
    ) {
      this.router.navigateByUrl('/game/:$me/waiting-game-validation');
    }
    return true;
  }
}
