import java.util.*;
public class happy2
{
	int temp,n,sum,val;
	happy2()
	{
		n=0;
	}
	void get_data()
	{
		Scanner sc=new Scanner (System.in);
		System.out.println("enter a number : ");
		n=sc.nextInt();
		temp=n;
	}
	void func_data()
	{
		while (n>9)
		{
			val=n;
			sum=0;
			while (val != 0)
			{
				sum=sum+(val%10);
				val=val/10;
			}
			n=sum;
		}
	}
	void out_data()
	{
		if (n==1)
		{
			System.out.println(temp+" is a happy no.");
		}
		else
		{
			System.out.println(temp+" is a sad no.");
		}
	}
	public static void main(String args[])
	{
		happy2 obj= new happy2();
		obj.get_data();
		obj.func_data();
		obj.out_data();
	}
}
