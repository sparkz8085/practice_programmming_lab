import java.util.*;
public class str_palindrome
{
	String str;
	String rev="";
	str_palindrome()
	{
		int i=0;
	}
	void get_val()
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter a string to check palindrome: ");
		str=sc.nextLine();
	}
	void pal_func()
	{
		for (int i=0;i<str.length();i++)
		{
			rev=str.charAt(i)+rev;
		}
	}
	void out_val()
	{
		if (str.equals(rev))
		{
			System.out.println(rev+" is palindrome");
		}
		else
		{
			System.out.println(rev+" is not palindrome");
		}
	}
	public static void main(String args[])
	{
		str_palindrome obj=new str_palindrome();
		obj.get_val();
		obj.pal_func();
		obj.out_val();
	}
}
