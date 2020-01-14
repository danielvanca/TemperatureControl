package com.enad.temperaturecontrol;


import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

public class TemperatureSetting extends AppCompatActivity
{
    public static final int CONNECTION_TIMEOUT = 10000;
    public static final int READ_TIMEOUT = 15000;
    TextView textPHP;
    Button button, button2;
    EditText setPoint;
    String TempSetPoint;
    String ServerURL = "http://10.0.2.2/TemperatureControl/phpAndroid/setPointTemperature.php" ;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_temperature_setting);
        textPHP = (TextView) findViewById(R.id.temperatureRead);
        button = (Button) findViewById(R.id.buttonGet);
        button2 = (Button) findViewById(R.id.setButton);
        setPoint = (EditText)findViewById(R.id.desiredTemp);

        button.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                new AsyncRetrieve().execute();
            }
        });

        button2.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                GetData();
                InsertData(TempSetPoint);
            }
        });
    }

    private class AsyncRetrieve extends AsyncTask<String, String, String>
    {
        ProgressDialog pdLoading = new ProgressDialog(TemperatureSetting.this);
        HttpURLConnection conn;
        URL url = null;
        //this method will interact with UI, here display loading message
        @Override
        protected void onPreExecute()
        {
            super.onPreExecute();
            pdLoading.setMessage("\tLoading...");
            pdLoading.setCancelable(false);
            pdLoading.show();
        }
        // This method does not interact with UI, You need to pass result to onPostExecute to display
        @Override
        protected String doInBackground(String... params)
        {
            try
            {
                // Enter URL address where your php file resides
                url = new URL("http://10.0.2.2/TemperatureControl/phpAndroid/getTemperature.php");
            }
            catch (MalformedURLException e)
            {
                // TODO Auto-generated catch block
                e.printStackTrace();
                return e.toString();
            }
            try
            {
                // Setup HttpURLConnection class to send and receive data from php
                conn = (HttpURLConnection) url.openConnection();
                conn.setReadTimeout(READ_TIMEOUT);
                conn.setConnectTimeout(CONNECTION_TIMEOUT);
                conn.setRequestMethod("GET");
                // setDoOutput to true as we receive data from json file
                conn.setDoOutput(true);
            }
            catch (IOException e1)
            {
                // TODO Auto-generated catch block
                e1.printStackTrace();
                return e1.toString();
            }

            try
            {
                int response_code = conn.getResponseCode();
                // Check if successful connection made
                if (response_code == HttpURLConnection.HTTP_OK)
                {
                    // Read data sent from server
                    InputStream input = conn.getInputStream();
                    BufferedReader reader = new BufferedReader(new InputStreamReader(input));
                    StringBuilder result = new StringBuilder();
                    String line;
                    while ((line = reader.readLine()) != null)
                    {
                        result.append(line);
                    }
                    // Pass data to onPostExecute method
                    return (result.toString());
                }
                else
                    {
                    return ("unsuccessful");
                    }
            }
            catch (IOException e)
            {
                e.printStackTrace();
                return e.toString();
            }
            finally
            {
                conn.disconnect();
            }
        }
        // this method will interact with UI, display result sent from doInBackground method
        @Override
        protected void onPostExecute(String result)
        {
            pdLoading.dismiss();
            textPHP.setText(result.toString());
        }
    }

    public void GetData()
    {
        TempSetPoint =  setPoint.getText().toString();
    }

    public void InsertData(final String setPoint)
    {
        class SendPostReqAsyncTask extends AsyncTask<String, Void, String>
        {
            @Override
            protected String doInBackground(String... params)
            {
                String sp = setPoint ;
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("setPoint", sp));
                try
                {
                    HttpClient httpClient = new DefaultHttpClient();
                    HttpPost httpPost = new HttpPost(ServerURL);
                    httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                    HttpResponse httpResponse = httpClient.execute(httpPost);
                    HttpEntity httpEntity = httpResponse.getEntity();
                }
                catch (ClientProtocolException e)
                {
                }
                catch (IOException e)
                {
                }
                return "Data Inserted Successfully";
            }
            @Override
            protected void onPostExecute(String result)
            {
                super.onPostExecute(result);
                Toast.makeText(TemperatureSetting.this, "Data Submit Successfully", Toast.LENGTH_LONG).show();
            }
        }
        SendPostReqAsyncTask sendPostReqAsyncTask = new SendPostReqAsyncTask();
        sendPostReqAsyncTask.execute(setPoint);
    }
}
