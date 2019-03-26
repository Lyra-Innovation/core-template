import { TestBed } from '@angular/core/testing';

import { GameStatusGuardService } from './game-status-guard.service';

describe('GameStatusGuardService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: GameStatusGuardService = TestBed.get(GameStatusGuardService);
    expect(service).toBeTruthy();
  });
});
