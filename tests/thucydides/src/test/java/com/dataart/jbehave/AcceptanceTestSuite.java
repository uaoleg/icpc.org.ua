package com.dataart.jbehave;

import net.thucydides.jbehave.ThucydidesJUnitStories;

public class AcceptanceTestSuite extends ThucydidesJUnitStories {
	
	public AcceptanceTestSuite() {
		//findStoriesCalled("**/Registration.story");
		//findStoriesCalled("**/Login.story");
		//findStoriesCalled("**/Import.story");
		//findStoriesCalled("**/PasswordReset.story");
		//findStoriesCalled("**.story");
		//findStoriesCalled("**/UserProfile.story");
		//findStoriesCalled("**/News.story");	
		//findStoriesCalled("**/QA.story");
		findStoriesCalled("**/Test.story");
		//findStoriesCalled("**/Team.story");
		
	}

}
