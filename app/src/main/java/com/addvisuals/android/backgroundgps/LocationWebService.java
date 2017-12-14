package com.addvisuals.android.backgroundgps;

import android.os.AsyncTask;
import android.util.Log;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;

import java.util.ArrayList;

public class LocationWebService extends AsyncTask<String, String, Boolean> {

    public LocationWebService() {
        // TODO Auto-generated constructor stub
    }

    @Override
    protected Boolean doInBackground(String... arg0) {

        ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
        nameValuePairs.add(new BasicNameValuePair("location", arg0[1]));

        HttpClient httpclient = new DefaultHttpClient();
        HttpPost httppost = new HttpPost(arg0[0]);
        HttpParams httpParameters = new BasicHttpParams();

        httpclient = new DefaultHttpClient(httpParameters);

        try {
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            HttpResponse response = httpclient.execute(httppost);
            HttpEntity httpEntity = response.getEntity();

            /**
             * Fetching response from the server
             */

            String serverResponse = EntityUtils.toString(httpEntity);
            Log.e("Server", "Server Responded OK");
            Log.e("ServerResponse", serverResponse);


        } catch (Exception e) {
            e.printStackTrace();
        }

        return null;
    }
}
