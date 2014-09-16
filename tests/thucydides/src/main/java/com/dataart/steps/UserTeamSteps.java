package com.dataart.steps;

import com.dataart.pages.TeamPage;

import net.thucydides.core.annotations.Step;
import net.thucydides.core.steps.ScenarioSteps;

public class UserTeamSteps extends ScenarioSteps{
	TeamPage teamPage;
	@Step
	public void the_user_is_on_the_teams_page(){
		teamPage.open();
	}
	@Step
	public void user_click_on_create_a_new_team_button(){
		teamPage.clickOn(teamPage.createTeamButton);
	}
	

}
