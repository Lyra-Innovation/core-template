import { Component, OnInit, Input, ViewChild } from '@angular/core';
import { BaseComponent } from 'renderer';
import { Store } from '@ngrx/store';
import { RootState, ModelAction } from 'presenter';
import {
  ShowNotification,
  LogoutAction
} from 'projects/presenter/src/lib/state';
import { DialogLauncherComponent } from 'projects/renderer/src/public_api';
import { GameStatus } from 'src/app/game-status';

@Component({
  selector: 'act-game-home',
  templateUrl: './game-home.component.html',
  styleUrls: ['./game-home.component.scss']
})
export class GameHomeComponent extends BaseComponent {
  @Input()
  gameStatus: number;

  @Input()
  userId: number;

  @Input()
  userName: number;

  @Input()
  myUserId: number;

  @Input()
  userComment: number;

  @ViewChild('requestDialog')
  requestDialog: DialogLauncherComponent;

  @ViewChild('validateDialog')
  validateDialog: DialogLauncherComponent;

  reason: string;

  constructor(protected store: Store<RootState>) {
    super();
  }

  protected getCssClasses() {
    return super.getCssClasses() + ' renderer-fill';
  }

  isValidationRequested() {
    return (
      this.gameStatus === GameStatus.PENDING_VALIDATION ||
      this.gameStatus === GameStatus.PENDING_REVIEW
    );
  }

  isFinished() {
    return this.gameStatus === GameStatus.FINISHED;
  }

  validate() {
    this.validateDialog.dialogRef.close();
    this.store.dispatch(
      new ModelAction({
        action: 'update',
        model: 'User',
        params: {
          game_status: this.gameStatus + 1
        },
        where: {
          id: this.userId
        }
      })
    );
    this.store.dispatch(
      new ShowNotification({
        message: 'views.validation.validated'
      })
    );
  }

  requestValidation() {
    this.requestDialog.dialogRef.close();
    this.store.dispatch(
      new ModelAction({
        action: 'update',
        model: 'User',
        params: {
          game_status: GameStatus.PENDING_REVIEW,
          comment_validation: this.reason
        },
        where: {
          id: this.userId
        },
        successActions: [
          {
            action: 'NavigateRoute',
            params: {
              route: '/waiting-game-validation'
            }
          }
        ]
      })
    );
    this.store.dispatch(
      new ShowNotification({
        message: 'views.validation.requested'
      })
    );
  }

  dinamizerMode(): boolean {
    // tslint:disable-next-line:triple-equals
    return this.userId != this.myUserId;
  }

  logout() {
    this.store.dispatch(new LogoutAction());
  }
}
