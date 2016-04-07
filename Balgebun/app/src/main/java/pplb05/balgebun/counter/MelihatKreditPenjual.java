package pplb05.balgebun.counter;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.widget.ImageView;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import pplb05.balgebun.R;

public class MelihatKreditPenjual extends AppCompatActivity {

    private String tempNama;
    private String tempUsername;
    private int tempPemasukan;
    //private String myUrl;

    private TextView namaCounter;
    private TextView usernameCounter;
    private TextView pemasukan;
    private ImageView image;

    private Bitmap myBitmap;

    private RequestQueue queue;

    public MelihatKreditPenjual() {
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_melihat_kredit_penjual);
        namaCounter = (TextView) findViewById(R.id.textView_nama);
        usernameCounter = (TextView) findViewById(R.id.textView_username);
        pemasukan = (TextView) findViewById(R.id.textView_nominal);
        image = (ImageView) findViewById(R.id.imageView);

        // Get uername of buyer
        SharedPreferences settings = getSharedPreferences("BalgebunLogin", Context.MODE_PRIVATE);
        tempUsername = settings.getString("username", "");
        TextView counterUsernameText = (TextView)findViewById(R.id.textView_nama);
        counterUsernameText.setText(tempUsername);

        getPemasukan();
        //getBitmapFromURL("http://aaa.esy.es/coba_wahid/img/counter/" +tempUsername+".jpg");


    }

       void getBitmapFromURL(String src){
           AsyncTask<String, Object, String> task = new AsyncTask<String, Object, String>() {
               @Override
               protected String doInBackground(String... params){
                   URL url = null;
                   try{
                       url = new URL(params[0]);
                   } catch (MalformedURLException e) {
                       e.printStackTrace();
                   }
                   try {
                       HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                       connection.setDoInput(true);
                       connection.connect();
                       InputStream input = connection.getInputStream();
                       myBitmap = BitmapFactory.decodeStream(input);
                   }catch (Exception e){
                       e.printStackTrace();
                   }
                   return null;
               }
               protected void onPostExecute(String unused){
                   image.setImageBitmap(myBitmap);
               }
           };
           task.execute(src);

    }

    public void getPemasukan(){
        queue = Volley.newRequestQueue(this.getApplicationContext());
        String url = "http://aaa.esy.es/coba_wahid/getPemasukanCounter.php";
        final StringRequest stringChess = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {

            @Override
            public void onResponse(String response) {
                Log.d("RESPONSE", "Login Response: " + response.toString());
                try {
                    JSONObject jObj = new JSONObject(response);
                    boolean error = jObj.getBoolean("error");
                    if (!error) {
                        String temp = jObj.getString("user");
                        temp = temp.substring(1, temp.length() - 1);
                        JSONObject jsonPemasukan = new JSONObject(temp.toString());
                        tempNama = jsonPemasukan.getString("nama_counter");
                        //tempUsername = jsonPemasukan.getString("username");
                        tempPemasukan = Integer.parseInt(jsonPemasukan.getString("pemasukan"));

                        namaCounter.setText(tempNama);
                        usernameCounter.setText(tempUsername);

                        int temp3 = tempPemasukan;
                        int ribuan = temp3/1000;
                        int temp2 = tempPemasukan - ribuan*1000;
                        if(temp2 == 0)
                            pemasukan.setText(ribuan +".000,00");
                        else
                            pemasukan.setText(ribuan +"." + temp2 +",00");

                        getBitmapFromURL("http://aaa.esy.es/coba_wahid/img/counter/" +tempUsername+".jpg");

                        Log.d("ABCD", "ABCD");
                    } else {

                    }
                } catch (JSONException e) {
                    e.printStackTrace();

                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }){

            @Override
            protected Map<String, String> getParams() {
                // Posting parameters to login url
                Map<String, String> params = new HashMap<String, String>();
                params.put("username", tempUsername);
                return params;
            }

        };

        queue.add(stringChess);

    }
}
