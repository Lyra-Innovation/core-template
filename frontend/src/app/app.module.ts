import { BrowserModule } from '@angular/platform-browser';
import { NgModule, InjectionToken, APP_INITIALIZER } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { StoreModule } from '@ngrx/store';
import { EffectsModule } from '@ngrx/effects';
import { StoreDevtoolsModule } from '@ngrx/store-devtools';
import { environment } from '../environments/environment';
import { RendererModule, ComponentRelation } from 'renderer';
import { PresenterModule } from 'presenter';
import { GameSummaryListItemComponent } from './custom/game-summary-list-item/game-summary-list-item.component';
import { MatChipsModule, MatIconModule, MatTooltipModule, MatListItem, MatListModule } from '@angular/material';
import { FlexLayoutModule } from '@angular/flex-layout';
import { DynamizerListItemComponent } from './custom/dynamizer-list-item/dynamizer-list-item.component';
import {
  TranslateModule,
  TranslateLoader,
  TranslateService
} from '@ngx-translate/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClient } from '@angular/common/http';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { GameHomeComponent } from './custom/game-home/game-home.component';
import { CardPickerComponent } from './custom/card-picker/card-picker.component';
import { RouletteComponent } from './custom/roulette/roulette.component';

export const DEFAULT_LANG = 'es';
export const LANGS = ['es'];

export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http, './assets/lang/', '.json');
}

export function initApplication(
  translateService: TranslateService
): () => void {
  return () =>
    new Promise(resolve => {
      translateService.setDefaultLang(DEFAULT_LANG);
      translateService.addLangs(LANGS);
      resolve();
    });
}

const customComponentRelation: ComponentRelation = {
  types: {
    'game-summary-list-item': {
      type: GameSummaryListItemComponent
    },
    'dynamizer-list-item': {
      type: DynamizerListItemComponent
    },
    'game-home': {
      type: GameHomeComponent
    },
    'card-picker': {
      type: CardPickerComponent
    }
  },
  keys: {}
};

@NgModule({
  declarations: [
    AppComponent,
    GameSummaryListItemComponent,
    DynamizerListItemComponent,
    GameHomeComponent,
    CardPickerComponent,
    RouletteComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    AppRoutingModule,
    PresenterModule.forRoot({baseApiUrl: environment.baseApiUrl}),
    RendererModule.forRoot({
      moduleComponentRelation: customComponentRelation
    }),
    MatChipsModule,
    MatTooltipModule,
    MatListModule,
    MatIconModule,
    FlexLayoutModule,
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: HttpLoaderFactory,
        deps: [HttpClient]
      },
      isolate: false
    }),
    StoreModule.forRoot({}),
    EffectsModule.forRoot([]),
    !environment.production ? StoreDevtoolsModule.instrument() : []
  ],
  providers: [
    {
      provide: APP_INITIALIZER,
      useFactory: initApplication,
      multi: true,
      deps: [TranslateService]
    }
  ],
  bootstrap: [AppComponent],
  entryComponents: [GameSummaryListItemComponent, CardPickerComponent, DynamizerListItemComponent, GameHomeComponent],
  exports: [CardPickerComponent]
})
export class AppModule {}
