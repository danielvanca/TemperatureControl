package com.enad.temperaturecontrol;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.view.View;import android.widget.EditText;

public class MainActivity extends AppCompatActivity
{

    EditText usernameET, passwordET;

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        usernameET = (EditText) findViewById(R.id.editTextUsername);
        passwordET = (EditText) findViewById(R.id.editTextPassword);
    }


    public void OnLogin(View view)
    {
        String username = usernameET.getText().toString();
        String password = passwordET.getText().toString();
        String type = "login";
        BackgroundWorker backgroundWorker = new BackgroundWorker(this);
        backgroundWorker.execute(type, username, password);
        startActivity(new Intent(this, TemperatureSetting.class));

    }

    public void OpenReg(View view)
    {
        Intent intent = new Intent(this, Register.class);
        startActivity(intent);
    }
}