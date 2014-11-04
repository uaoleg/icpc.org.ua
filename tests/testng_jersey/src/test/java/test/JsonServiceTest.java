package test;

import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.MultivaluedMap;
import javax.ws.rs.core.UriBuilder;

import org.json.JSONObject;
import org.testng.Assert;
import org.testng.annotations.Test;

import com.sun.jersey.api.client.Client;
import com.sun.jersey.api.client.ClientResponse;
import com.sun.jersey.api.client.WebResource;
import com.sun.jersey.api.client.config.ClientConfig;
import com.sun.jersey.api.client.config.DefaultClientConfig;
import com.sun.jersey.core.util.MultivaluedMapImpl;

public class JsonServiceTest {

	@Test
	public void ImportTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client
				.resource("http://acc.icpc.org.ua/user/baylor");
		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("email", "111@mailinator.com");
		formData.add("password", "123456");
		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.post(ClientResponse.class, formData);

		JSONObject obj = new JSONObject(response.getEntity(String.class));

		Assert.assertEquals(obj.get("errors"), false);
		Assert.assertEquals(response.getStatus(), 200);
	}

	@Test
	public void registrationTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/auth/signup").build());

		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("firstNameUk", "test");
		formData.add("middleNameUk", "test");
		formData.add("lastNameUk", "test");

		formData.add("email", "Den" + (int) (Math.random() * 10000 + 1)
				+ "@mail.ru");
		formData.add("password", "123456");
		formData.add("passwordRepeat", "123456");
		formData.add("schoolId", "526e889144579850658b456f");
		formData.add("type", "student");
		formData.add("rulesAgree", "1");
		formData.add("recaptchaIgnore", "1");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());

		JSONObject obj = new JSONObject(response.getEntity(String.class));
		Assert.assertEquals(obj.get("errors"), false);
		Assert.assertEquals(response.getStatus(), 200);
	}

	@Test
	public void registrationNegativeTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/auth/signup").build());
		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("firstNameUk", "test");
		formData.add("middleNameUk", "test");
		formData.add("lastNameUk", "test");
		formData.add("email", "111@mailinator.com");
		formData.add("password", "123456");
		formData.add("passwordRepeat", "123456");
		formData.add("schoolId", "526e889144579850658b456f");
		formData.add("type", "student");
		formData.add("rulesAgree", "1");
		formData.add("recaptchaIgnore", "1");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());

		JSONObject obj = new JSONObject(response.getEntity(String.class));

		Assert.assertTrue((obj.get("errors")).toString().contains(
				"Email is not unique in DB."));

		Assert.assertEquals(response.getStatus(), 200);
	}

	@Test
	public void getResultsJsonTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/results/GetResultsListJson").build());

		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("year", "2014");
		formData.add("geo", "arc");
		formData.add("_search", "false");
		formData.add("nd", "1410185515806");
		formData.add("rows", "1000");
		formData.add("page", "1");
		formData.add("sidx", "place");
		formData.add("sord", "asc");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=495earvia5170r7o7nfdpj2uo1; language=en")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());
		System.out.println(response.getEntity(String.class));
		Assert.assertEquals(response.getStatus(), 200);
	}
	
	@Test
	public void deleteMarkedTeamsTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client
				.resource("http://acc.icpc.org.ua/test/team/delete");		
		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.post(ClientResponse.class);

	
		Assert.assertEquals(response.getStatus(), 200);
	}
	//

	// Doesn't work
	// ///////////////////////////////////////////////////////////////
	/*@Test
	public void saveProfileCorrectTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/user/additionalStudentSave").build());

		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("language", "en");
		formData.add("dateOfBirth", "2014-09-08");
		formData.add("phoneHome", "777777");
		formData.add("phoneMobile", "5555555");
		formData.add("skype", "test");
		formData.add("tShirtSize", "XXL");
		formData.add("vtShirtSize", "XXL");
		formData.add("acmNumber", "234234234234");
		formData.add("studyField", "IT");
		formData.add("speciality", "developer");
		formData.add("faculty", "math");
		formData.add("group", "1");
		formData.add("course", "1");
		formData.add("schoolAdmissionYear", "1983");
		formData.add("document", "213423423");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=jj0eqdqjnj0ngkueqj3f63u3t1; language=en")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());
		System.out.println(response.getEntity(String.class));

		Assert.assertEquals(response.getStatus(), 200);
	}

	@Test
	public void exportForRegistrationTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/team/exportRegistration").build());

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=495earvia5170r7o7nfdpj2uo1; language=en")
				.get(ClientResponse.class);
		System.out.println(response.getStatus());

		Assert.assertTrue(response.getEntity(String.class).contains("HEPY-123"));

		Assert.assertEquals(response.getStatus(), 200);

	}

	@Test
	public void exportForCheckingSystemTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/team/exportRegistration").build());

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=495earvia5170r7o7nfdpj2uo1; language=en")
				.get(ClientResponse.class);
		System.out.println(response.getStatus());
		Assert.assertTrue(response.getEntity(String.class).contains("HEPY-123"));

		Assert.assertEquals(response.getStatus(), 200);

	}

	@Test
	public void manageTeamsNegativeTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/staff/team/manage").build());

		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("name", "YNC111");
		formData.add("memberIds", "52947cef445798c85c8c1e77");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=h6o5b2jls2mlaqibvglr49h053; language=en")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());
		JSONObject obj = new JSONObject(response.getEntity(String.class));
		Assert.assertTrue((obj.get("errors")).toString().contains(
				"The number of members should be greater or equal then 3."));
		Assert.assertEquals(response.getStatus(), 200);
	}

	@Test
	public void CreateTeamsTest() {
		ClientConfig config = new DefaultClientConfig();
		Client client = Client.create(config);
		WebResource webResource = client.resource(UriBuilder.fromUri(
				"http://acc.icpc.org.ua/staff/team/manage").build());

		MultivaluedMap<String, String> formData = new MultivaluedMapImpl();
		formData.add("name", "YNCwer");
		formData.add("memberIds", "52947cef445798c85c8c1e77");
		formData.add("memberIds", "52947d24445798765d8c2483");
		formData.add("memberIds", "52947d56445798255d8c2609");

		ClientResponse response = webResource
				.accept(MediaType.APPLICATION_JSON_TYPE)
				.header("X-Requested-With", "XMLHttpRequest")
				.header("Accept-Language", "en-US,en;q=0.8")
				.header("Cookie",
						"_ga=GA1.3.920165144.1407417402; PHPSESSID=h6o5b2jls2mlaqibvglr49h053; language=en")
				.post(ClientResponse.class, formData);
		System.out.println(response.getStatus());

		JSONObject obj = new JSONObject(response.getEntity(String.class));
		Assert.assertTrue((obj.get("errors")).equals(false));
		Assert.assertEquals(response.getStatus(), 200);
	}
	*/
}
