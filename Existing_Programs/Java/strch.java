import java.util.*;
public class strch
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		int a,b,v=0;
		char chr;
		System.out.println("enter a string : ");
		String st=sc.nextLine();
		b=st.length();
		for (a=0;a<b;a++)
		{
			chr=st.charAt(a);
			{
				if (chr=='e'||chr=='E')
				chr='*';
			}
			System.out.print(chr);
		}
		System.out.println();
	}
}
