import java.util.Scanner;

public class surname
{
    public static void main(String args[])
    {
        String st, sn, st1 = "", st2 = "";
        int i, p;
        char chr;
        Scanner sc= new Scanner(System.in);
        System.out.print("Enter the full name: ");
        st = sc.nextLine();
        p = st.lastIndexOf(' ');
        sn = st.substring(p + 1);
        st1 = st.charAt(0) + ".";
        for (i = 1; i < p; i++)
        {
            chr = st.charAt(i);
            if (chr == ' ')
            {
                st1 = st1 + " " + st.charAt(i + 1) + ".";
            }
        }
        st2 = st1 + " " + sn;
        System.out.print("Initials with surname: ");
        System.out.println(st2);
    }
}
